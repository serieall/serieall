<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    protected $fillable = [
        'name',
        'nationality_url'];

    # Une nationalité peut créer plusieurs séries
    public function shows()
    {
        return $this->belongsToMany('App\Models\Show');
    }
}
