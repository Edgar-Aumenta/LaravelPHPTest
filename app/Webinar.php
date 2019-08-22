<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static findOrFail($id)
 * @property mixed id
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
        'register_url',
        'visible',
        'user_id',
    ];

}
