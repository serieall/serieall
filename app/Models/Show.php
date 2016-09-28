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

    # Une série peut avoir plusieurs artistes : Ce sont les créateurs
    public function artists()
    {
        return $this->belongsToMany('App\Models\Artist');
    }

    # Une série peut avoir plusieurs chaines
    public function channels()
    {
        return $this->belongsToMany('App\Models\Channel');
    }

    # Une série peut avoir plusieurs épisodes
    public function episodes()
    {
        return $this->hasManyThrough('App\Models\Episode', 'App\Models\Season');
    }

    # Une série peut avoir plusieurs genres
    public function genres()
    {
        return $this->belongsToMany('App\Models\Genre');
    }

    # Une série peut avoir plusieurs nationalités
    public function nationalities()
    {
        return $this->belongsToMany('App\Models\Nationality');
    }

    # Une série peut avoir plusieurs saisons
    public function seasons()
    {
        return $this->hasMany('App\Models\Season');
    }
}
