<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'thetvdb_id',
        'name',
        'ba',
        'moyenne',
        'nbnotes',
        'show_id'];

    # Une saison peut avoir plusieurs épisodes
    public function episodes()
    {
        return $this->hasMany('App\Models\Episode');
    }

    # Une saison appartient à une seule série
    public function show()
    {
        return $this->belongsTo('App\Models\Show');
    }


}