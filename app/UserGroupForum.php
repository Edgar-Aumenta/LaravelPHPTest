<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $userGroupRow)
 */
class UserGroupForum extends Model
{
    protected $connection = 'mysql_forum';
    protected $table = 'pbb_user_group';
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'user_id',
        'group_leader',
        'user_pending'
    ];
}
