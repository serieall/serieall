<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    protected $fillable = [
        'name',
        'nationality_url'];

    public function shows()
    {
        return $this->belongsToMany('App\Models\Show');
    }
}
