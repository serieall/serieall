<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'name',
        'pays',
        'channel_url'];

    public function shows()
    {
        return $this->belongsToMany('App\Models\Show');
    }
}
