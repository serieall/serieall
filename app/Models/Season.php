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

    public function show()
    {
        return $this->belongsTo('App\Models\Show');
    }

    public function episodes()
    {
        return $this->hasMany('App\Models\Episode');
    }
}