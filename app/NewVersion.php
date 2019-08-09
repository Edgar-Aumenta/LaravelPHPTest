<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewVersion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'version_code',
      'version_name',
      'current_version',
      'release_date',
      'estimate_size',
      'user_id'
    ];
}
