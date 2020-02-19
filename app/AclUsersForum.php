<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $aclUserRow)
 */
class AclUsersForum extends Model
{
    protected $connection = 'mysql_forum';
    protected $table = 'pbb_acl_users';
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'forum_id',
        'auth_option_id',
        'auth_role_id',
        'auth_setting',
    ];
}
