<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $connection = 'mysql_forum';
    protected $table = 'pbb_forums';
}
