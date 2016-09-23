<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    protected $fillable = [
        'thetvdb_id',
        'show_url',
        'name',
        ];

    public function channels()
    {
        return $this->belongsToMany('App\Models\Channel');
    }

    public function nationalities()
    {
        return $this->belongsToMany('App\Models\Nationality');
    }

    public function seasons()
    {
        return $this->hasMany('App\Models\Season');
    }

    public function episodes()
    {
        return $this->hasManyThrough('App\Models\Episode', 'App\Models\Season');
    }
}
