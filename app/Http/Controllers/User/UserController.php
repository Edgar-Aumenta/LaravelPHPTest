<?php

namespace App\Http\Controllers\User;

use App\AclUsersForum;
use App\Forum;
use App\GroupsForum;
use App\Helpers;
use App\User;
use App\Pluggable;
use App\Http\Controllers\ApiController;
use App\UserForum;
use App\UserGroupForum;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use App\FieldsDataForum;


class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['encryptPassword', 'decrypt', 'userExist']);
        $this->middleware('isAdmin:api')->except(['encryptPassword', 'userInfo', 'passwordChange', 'decrypt', 'userExist']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $isAdmin = false;
        $rows = $request['rows'];
        if($request->has('admin')) $isAdmin = $request['admin'];

        $currentUser = $request->user();
        $users = User::where('admin', $isAdmin)
                        ->where('id', '!=', $currentUser['id'])
                        ->paginate($rows);

        return $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $isAdmin = false;
        $rows = $request['rows'];
        if($request->has('admin')) $isAdmin = $request['admin'];

        $currentUser = $request->user();
        $users = User::where('admin', $isAdmin)
                        ->where('username', 'LIKE', '%'.$request['username'].'%')
                        ->paginate($rows);

        return $users;
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

        // TODO Verify in lower case
        if(!$request->has('admin')){
            $data['admin'] = User::USUARIO_REGULAR;
        } else if ($request['admin'] == null || ($request['admin'] != true && $request['admin'] == false)) {
            $data['admin'] = User::USUARIO_REGULAR;
        }
        else if ($request['admin'] == true && $request['admin'] != false) {
            $data['admin'] = User::USUARIO_ADMMINISTRADOR;
        }

        $data['username'] = strtolower($data['username']);
        $data['email'] = strtolower($data['email']);

        if($request->has('tos') && $data['tos'] == null) $data['tos'] = 0;
        if($request->has('send_notifications') && $data['send_notifications'] == null) $data['send_notifications'] = 0;
        // Default value for enable when user was create
        // TODO change for default value in true in database
        if(!$request->has('enable')){
            $data['enable'] = User::ENABLE_USER;
        } else if ($data['enable'] == null){
            $data['enable'] = User::ENABLE_USER;
        }
        // Register user
        $user = User::create($data);
        // Register user forum
        $userForum = $this->createUserForum($data);
        // Additional register for user forum
        $this->userRegistrationToGroup($userForum);
        $this->userRegistrationToForums($userForum);
        if($request->has('serial_number'))
        {
            $this->userSerialRegistration($userForum, $data['serial_number']);
        }

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
     * Password reset (this method only use for administrators)
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function passwordReset(Request $request)
    {
        $rules = [
            'username'  => 'required',
            'password'  => 'required',
            'password_change_required' => 'nullable'
        ];

        $this->validate($request, $rules);

        if (!isset($request['password_change_required']))
        {
            $passwordChangeRequired = false;
        }
        else
        {
            $passwordChangeRequired = $request['password_change_required'];
        }

        // Obtain user in new site and forum

        $user = $this->findOrFailUser($request['username']);
        $userForum = $this->findUserForum($request['username']);        

        $this->changeUserPassword($user, $userForum, $request['password'], $passwordChangeRequired);

        return $this->messageResponse('The password has been reset!');
    }

    /**
     * Password change for users
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function passwordChange(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'password'         => 'required|confirmed'
        ];

        $this->validate($request, $rules);

        // Obtain user in new site and forum
        $currentUser = $request->user();
        $userForum = $this->findUserForum($currentUser->username);

        if(!Pluggable::wp_check_password($request['current_password'], $currentUser->password)){
            return $this->errorResponse('The current password is incorrect!', 401);
        }

        $this->changeUserPassword($currentUser, $userForum, $request['password'],false);

        return $this->messageResponse('The password has been changed!');
    }

    /**
     * Decrypt text encrypted
     *
     * @param Request $request
     * @return JsonResponse
     */
    function decrypt(Request $request)
    {
        $plainText = $this->decryptSo($request['encrypted_text'], 'PCSWebLogin123456789012345678901');

        return response()->json(['decrypt' => $plainText] , 200);
    }

    /**
     * Verify if user currently exist
     *
     * @param Request $request
     * @return Response Represent a scalar value
     */
    function userExist(Request $request)
    {
        $username = $request['username'];
        $user = null;
        if(Helpers::isEmail($username)){
            $user = User::where('email', $username)->first();
        }else{
            $user = User::where('username', $username)->first();
        }
        return response(($user == null) ? 0 : 1);
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
        if($request->has('password_change_required')) $user['password_change_required'] = $request['password_change_required'];
        if($request->has('serial_number')) $user->serial_number = $request->serial_number;
    }

    /**
     * Find or fail user by username or email
     * @param $value
     *
     * @return User
     */
    private function findOrFailUser($value)
    {
        if(Helpers::isEmail($value)){
            return $this->findOrFailUserByEmail($value);
        }else{
            return $this->findOrFailUserByUsername($value);
        }
    }

    /**
     * Find user by username
     * @param $username
     *
     * @return User
     */
    private function findOrFailUserByUsername($username)
    {
        return User::where('username', $username)->firstOrFail();
    }

    /**
     * Find user by email
     * @param $email
     *
     * @return User
     */
    private function findOrFailUserByEmail($email)
    {
        return User::where('email', $email)->firstOrFail();
    }

    /**
     * Find user forum by username or email
     * @param $value
     *
     * @return UserForum
     */
    private function findUserForum($value)
    {
        if(Helpers::isEmail($value)){
            return $this->findUserForumByEmail($value);
        }else{
            return $this->findUserForumByUsername($value);
        }
    }

    /**
     * Find user forum by username
     * @param $username
     * @return UserForum
     */
    private function findUserForumByUsername($username)
    {
        return UserForum::where('username', $username )->first();
    }

    /**
     * Find user forum by email
     * @param $email
     *
     * @return UserForum
     */
    private function findUserForumByEmail($email)
    {
        return UserForum::where('user_email', $email )->first();
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

    private function userSerialRegistration(UserForum $userForum, $serial_number)
    {
        $fieldDataRow = array(
            'user_id'			=> $userForum->user_id,
            'pf_serial_number'	=> $serial_number,
        );

        FieldsDataForum::create($fieldDataRow);
    }

    /**
     * Change user password in site and forum
     * @param User $user
     * @param UserForum $userForum
     * @param $newPasswordPlainText
     */
    private function changeUserPassword(User $user, $userForum, $newPasswordPlainText, $passwordChangeRequired)
    {
        // Generate password hash
        $newPasswordHash = Pluggable::wp_hash_password($newPasswordPlainText);
        // Save password for new site
        $user->password = $newPasswordHash;
        $user->password_change_required = $passwordChangeRequired;
        $user->save();
        // Save password for forum new site
        if($userForum != null)
        {
            $userForum->user_password  = $newPasswordHash;
            $userForum->save();
        }
    }

    private function decryptSo($str, $key)
    {
        $method = 'aes-256-cbc';
        $data = urldecode($str);        
        $vector = 'PCSWebLogin98765';
        $crypt = openssl_decrypt($data, $method, $key, 0, $vector);                               
        return $crypt;
    }

}
