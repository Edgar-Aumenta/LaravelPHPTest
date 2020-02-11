<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateVersion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version_code',
        'version_name',
        'version_url',
        'current_version',
        'release_date',
        'estimate_size',
        'readme_url',
        'update_guide_url',
        'user_id'
    ];
}
