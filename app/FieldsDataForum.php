<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $aclUserRow)
 */
class FieldsDataForum extends Model
{
    protected $connection = 'mysql_forum';
    protected $table = 'pbb_profile_fields_data';
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'pf_serial_number',
    ];
}