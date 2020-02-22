<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $eventRow)
 */
class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];
}
