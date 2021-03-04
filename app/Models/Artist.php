<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Artist.
 *
 * @property string $name
 * @property string $artist_url
 */
class Artist extends Model
{
    protected $table = 'artists';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'artist_url',
    ];

    public function episodes(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Episode', 'artistable');
    }

    public function shows(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Show', 'artistable');
    }

    public function articles(): MorphToMany
    {
        return $this->morphToMany('App\Models\Article', 'articlable');
    }
}
