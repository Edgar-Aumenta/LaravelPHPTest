<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static findOrFail($id)
 * @property mixed id
 * @property mixed start_date
 * @property mixed start_time
 * @property mixed name
 * @property mixed description
 * @property mixed register_url
 * @property mixed recoded_url
 * @property mixed $visible
 * @property mixed user_id
 */
class Webinar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date',
        'start_time',
        'name',
        'description',
        'register_url',
        'recoded_url',
        'visible',
        'user_id',
    ];

}
