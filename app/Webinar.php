<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static findOrFail($id)
 * @property mixed id
 * @property mixed start_date
 * @property mixed start_time
 * @property mixed time_zone_desc
 * @property mixed name
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
        'time_zone_desc',
        'name',
        'register_url',
        'recorded_url',
        'visible',
        'user_id',
    ];

}
