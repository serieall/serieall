<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'name',
        'genre_url'];

    # Un genre peut appartenir à plusieurs séries
    public function shows()
    {
        return $this->belongsToMany('App\Models\Show');
    }
}
