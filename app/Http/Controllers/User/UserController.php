<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Pluggable;
use App\Http\Controllers\ApiController;
use App\UserForum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('encryptPassword');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $users = User::all();

        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = User::GetRulesForStore();

        $this->validate($request, $rules);

        $campos = $request->all();
        $campos['password'] = Pluggable::wp_hash_password($request->password);
        $campos['verified'] = User::USUARIO_VERIFICADO;
        $campos['verification_token'] = User::generateTokenVerification();
        $campos['admin'] = User::USUARIO_REGULAR;
        if($campos['tos'] == null) $campos['tos'] = 0;
        if($campos['enable'] == null) $campos['enable'] = User::ENABLE_USER;
        if($campos['send_notifications'] == null) $campos['send_notifications'] = 0;

        $user = User::create($campos);
        $userFromForum = $this->createUserForum($campos);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user)
    {
        $rules = User::GetRulesForUpdate($user);

        $this->validate($request, $rules);

        $this->compareChangesAndAssign($request, $user);

        if(!$user->isDirty()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
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

    /**
     * Create user for forum
     *
     * @param array $fields
     * */
    public function createUserForum($fields)
    {
        UserForum::create();
    }

    /**
     * Compare chances and assign if there are
     * @param Request $request
     * @param User $user
     */
    private function compareChangesAndAssign(Request $request, User &$user)
    {
        if($request->has('email')) $user->email = $request->email;
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
}
