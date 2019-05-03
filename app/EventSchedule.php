<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'location_id',
        'event_id',
        'lodging_id',
        'register_title',
        'register_url',
        'mi_title',
        'mi_url',
        'visible',
        'user_id',
    ];

    protected $location;
    protected $event;
    protected $lodging;
    protected $user;
    protected $register;
    protected $moreInformation;

    /**
     * Get the location record associated with the event schedule.
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * Get the event record associated with the event schedule.
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    /**
     * Get the lodging record associated with the event schedule.
     */
    public function lodging()
    {
        return $this->belongsTo('App\Lodging');
    }

    /**
     * Get the user record associated with the event schedule.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the register info in array associative.
     */
    public function register()
    {
        return [
            "title" => $this->register_title,
            "url" => $this->register_url
        ];
    }

    /**
     * Get the more information info in array associative.
     */
    public function moreInformation()
    {
        return [
            "title" => $this->mi_title,
            "url" => $this->mi_url
        ];
    }
}
