<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use App\Pluggable;

class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'address_1' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'day_phone' => 'required',
            'company' => 'required',
        ];

        $this->validate($request, $rules);

        $campos = $request->all();
        // $campos['password'] = bcrypt($request->password);
        $campos['password'] = $request->password; // The encryption for password is part of client
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generateTokenVerification();
        $campos['admin'] = user::USUARIO_REGULAR;

        $user = User::create($campos);

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
        /*$rules = [
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'address_1' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'day_phone' => 'required',
            'company' => 'required',
        ];*/

        $rules = [
            'username' => 'unique:users,username,' . $user->id,
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
        ];

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

    public function userInfo(Request $request)
    {
        return $this->showOne($request->user());
    }

    public function encryptPassword(Request $request)
    {
        $hash = Pluggable::wp_hash_password("Aumenta10!");
        $checkPass = Pluggable::wp_check_password("Aumenta10!", '$P$BShFwyg7DjATPzCdeQRkX.WqKyWWZC.');

        return response()->json(['hash' => $hash, 'checkPass' => $checkPass] , 200);
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
