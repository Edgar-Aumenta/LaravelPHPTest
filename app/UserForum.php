<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserForum extends Model
{
    protected $connection = 'mysql_forum';
    protected $table = 'pbb_users';
}
