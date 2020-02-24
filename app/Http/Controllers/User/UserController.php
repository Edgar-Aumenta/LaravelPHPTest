<?php

namespace App\Http\Controllers\User;

use App\AclUsersForum;
use App\Forum;
use App\GroupsForum;
use App\User;
use App\Pluggable;
use App\Http\Controllers\ApiController;
use App\UserForum;
use App\UserGroupForum;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['encryptPassword']);
        $this->middleware('isAdmin:api')->except(['encryptPassword', 'userInfo']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $currentUser = $request->user();
        $users = User::where('admin', 'true')
                        ->where('id', '!=', $currentUser['id'])
                        ->get();

        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request)
    {
        $rules = User::GetRulesForStore();

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = Pluggable::wp_hash_password($request->password);
        $data['verified'] = User::USUARIO_VERIFICADO;
        $data['verification_token'] = User::generateTokenVerification();
        $data['admin'] = User::USUARIO_REGULAR;
        $data['username'] = strtolower($data['username']);
        $data['email'] = strtolower($data['email']);

        if($request->has('tos') && $data['tos'] == null) $data['tos'] = 0;
        if($request->has('enable') && $data['enable'] == null) $data['enable'] = User::ENABLE_USER;
        if($request->has('send_notifications') && $data['send_notifications'] == null) $data['send_notifications'] = 0;
        // Register user
        $user = User::create($data);
        // Register user forum
        $userForum = $this->createUserForum($data);
        // Additional register for user forum
        $this->userRegistrationToGroup($userForum);
        $this->userRegistrationToForums($userForum);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $username
     * @return JsonResponse
     */
    public function show($username)
    {
        $user = $this->findOrFailUserByUsername($username);

        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $username
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $username)
    {
        $user = $this->findOrFailUserByUsername($username);

        $rules = User::GetRulesForUpdate($user);

        $this->validate($request, $rules);

        $this->compareChangesAndAssign($request, $user);

        if(!$user->isDirty()){
            return $this->messageResponse('Nothing to update', 200);
        }

        $user->save();

        return $this->messageResponse('Updated!', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $username
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($username)
    {
        $user = $this->findOrFailUserByUsername($username);

        $user->delete();

        return $this->messageResponse("Erased!", 200);
    }

    /**
     * Get user basic information
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function userInfo(Request $request)
    {
        return $this->showOne($request->user());
    }

    /**
     * Get encrypt password
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function encryptPassword(Request $request)
    {
        $hash = Pluggable::wp_hash_password($request->plain_text);
        //$check = Pluggable::wp_check_password("Aumenta10!", '$P$BShFwyg7DjATPzCdeQRkX.WqKyWWZC.');
        //$wp_hasher = new PasswordHash(8, true);
        //$check = $wp_hasher->CheckPassword("Aumenta10!", '$P$BShFwyg7DjATPzCdeQRkX.WqKyWWZC.');

        return response()->json(['hash' => $hash] , 200);
    }

    public function passwordReset(Request $request)
    {
        $rules = [
            'username'  => 'required',
            'password'  => 'required'
        ];

        $this->validate($request, $rules);

        // Search user in new site an forum
        $user = $this->findOrFailUserByUsername($request['username']);
        $userForum = $this->findUserForumByUsername($request['username']);

        // Generate password hash
        $newPassword = Pluggable::wp_hash_password($request['password']);

        // Save password for new site
        $user->password = $newPassword;
        $user->save();

        // Save password for forum new site
        if($userForum != null)
        {
            $userForum->user_password  = $newPassword;
            $userForum->save();
        }

        return $this->messageResponse('The password has been reset!');
    }

    /**
     * Create user for forum
     *
     * @param array $data
     *
     * @return UserForum
     * @throws Exception
     */
    private function createUserForum($data)
    {
        $user_row = array(
            'username'				=> $data['username'],
            'username_clean'	    => $data['username'], // TODO change for utf8_clean_string($data['username']);
            'user_password'			=> $data['password'],
            'user_email'			=> $data['email'],
            'group_id'				=> (int) GroupsForum::GetForUserRegistered()->group_id,
            'user_type'				=> UserForum::USER_NORMAL,
            'user_new'              => 1
        );

        // These are the additional vars able to be specified
        $additional_vars = UserForum::GetAdditionalVars();
        // Now fill the sql array with not required variables
        foreach ($additional_vars as $key => $default_value)
        {
            $user_row[$key] = (isset($user_row[$key])) ? $user_row[$key] : $default_value;
        }

        return UserForum::create($user_row);
    }

    /**
     * Compare chances and assign if there are
     * @param Request $request
     * @param User $user
     */
    private function compareChangesAndAssign(Request $request, User &$user)
    {
        if($request->has('email')) $user->email = strtolower($request->email);
        if($request->has('first_name')) $user->first_name = $request->first_name;
        if($request->has('last_name')) $user->last_name = $request->last_name;
        if($request->has('username')) $user->username = $request->username;
        if($request->has('website')) $user->website = $request->website;
        if($request->has('send_notifications')) $user->send_notifications = $request->send_notifications;
        if($request->has('url_image')) $user->url_image = $request->url_image;
        if($request->has('url_image_thumbnail')) $user->url_image_thumbnail = $request->url_image_thumbnail;
        if($request->has('address_1')) $user->address_1 = $request->address_1;
        if($request->has('address_2')) $user->address_2 = $request->address_2;
        if($request->has('city')) $user->city = $request->city;
        if($request->has('state')) $user->state = $request->state;
        if($request->has('zip')) $user->zip = $request->zip;
        if($request->has('country')) $user->country = $request->country;
        if($request->has('day_phone')) $user->day_phone = $request->day_phone;
        if($request->has('tos')) $user->tos = $request->tos;
        if($request->has('company')) $user->company = $request->company;
        if($request->has('enable')) $user->enable = $request->enable;
    }

    private function findOrFailUserByUsername($username)
    {
        return User::where('username', $username )->firstOrFail();
    }

    private function findUserForumByUsername($username)
    {
        return UserForum::where('username', $username )->first();
    }

    private function userRegistrationToGroup(UserForum $userForum)
    {
        $groupId = (int) GroupsForum::GetForUserRegistered()->group_id;
        $userGroupRow = array(
            'group_id'      => $groupId,
            'user_id'       => $userForum->user_id,
            'group_leader'  => 0, // default value
            'user_pending' => 0 // default value
        );
        UserGroupForum::create($userGroupRow);
    }

    private function userRegistrationToForums(UserForum $userForum)
    {
        $forums = Forum::all();

        foreach ($forums as $forum)
        {
            $aclUserRow = array(
                'user_id'			=> $userForum->user_id,
                'forum_id'	        => $forum->forum_id,
                'auth_option_id'    => 0,
                'auth_role_id'	    => 15,
                'auth_setting'		=> 0
            );

            AclUsersForum::create($aclUserRow);
        }
    }
}
