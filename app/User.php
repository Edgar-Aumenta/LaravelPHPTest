<?php

namespace App;

use App\Notifications\PasswordResetNotification;
use App\Pluggable;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use League\OAuth2\Server\Exception\OAuthServerException;

/**
 * @method static create(array $data)
 * @method static where(string $string, $value)
 * @property mixed email
 * @property mixed password
 * @property bool password_change_required
 * @property mixed first_name
 */
class User extends Authenticable
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
        'enable',
        'password_change_required',
        'last_login_date',
        'serial_number'        
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
        'last_login_date' => 'datetime',
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
        if(Helpers::isEmail($username)){
            return $this->where('email', $username)->first();
        }else{
            return $this->where('username', $username)->first();
        }
    }

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param string $password
     * @return bool
     * @throws OAuthServerException
     */
    public function validateForPassportPasswordGrant($password)
    {       
        if(Pluggable::wp_check_password($password, $this->password))
        {
            if($this->isEnable()){
                $user =  $this->findForPassport($this->username);
                $user -> last_login_date = now();
                $user->save();
                return true;
            } else {
                throw new OAuthServerException('User account is not active', 6, 'account_inactive', 401);
            }
        }
    }

    public static function GetRulesForStore()
    {
        return [
            'username'  => 'required|unique:users',
            'email'     => 'required|email|unique:users',
            'password'  => 'required',
            'address_1' => 'required',
            'city'      => 'required',
            'zip'       => 'required',
            'country'   => 'required',
            'day_phone' => 'required',
            'company'   => 'required',
        ];
    }

    public static function GetRulesForUpdate(User $user)
    {
        return [
            'username'  => 'unique:users,username,' . $user->id,
            'email'     => 'email|unique:users,email,' . $user->id
        ];
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify( new PasswordResetNotification($token, $this->email, $this->first_name));
    }

}
