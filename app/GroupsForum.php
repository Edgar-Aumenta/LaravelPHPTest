<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method where(string $key, string $value)
 */
class GroupsForum extends Model
{
    const REGISTERED = 'REGISTERED';

    protected $connection = 'mysql_forum';
    protected $table = 'pbb_groups';

    public function findForUserRegistered(){
        return $this->where('group_name', $this::REGISTERED)->first();
    }
}
