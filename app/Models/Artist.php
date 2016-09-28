<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = [
        'name',
        'artist_url'];

    # Un artiste peut avoir créé plusieurs séries
    public function shows()
    {
        return $this->belongsToMany('App\Models\Show');
    }
}
