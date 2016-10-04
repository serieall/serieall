<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = [
        'thetvdb_id',
        'numero',
        'name',
        'name_fr',
        'resume',
        'particularite',
        'diffusion_us',
        'diffusion_fr',
        'guests',
        'ba',
        'moyenne',
        'nbnotes',
        'season_id'];

    # Un épisode n'appartient qu'à une seule saison
    public function season()
    {
        return $this->belongsTo('App\Models\Season');
    }


    public function artists()
    {
        return $this->belongsToMany('App\Models\Artist');
    }
}
