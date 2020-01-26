<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

/**
 * @method static create(array $campos)
 * @method where(string $string, $username)
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';

    const USUARIO_ADMMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';

    const ENABLE_USER = '1';
    const DISABLE_USER = '0';

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
        'first_name',
        'last_name',
        'username',
        'website',
        'send_notifications',
        'url_image',
        'url_image_thumbnail',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip',
        'country',
        'day_phone',
        'tos',
        'company',
        'enable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isVerified()
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    public function isAdmin()
    {
        return $this->admin == User::USUARIO_ADMMINISTRADOR;
    }

    public function isEnable()
    {
        return $this->enable == User::ENABLE_USER;
    }

    public static function generateTokenVerification()
    {
        return Str::random(40);
    }

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return User
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
}
