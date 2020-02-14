<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AclUsersForum extends Model
{
    protected $connection = 'mysql_forum';
    protected $table = 'pbb_acl_users';
}
