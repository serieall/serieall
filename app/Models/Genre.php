<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Genre.
 *
 * @property string $name
 * @property string $genre_url
 */
class Genre extends Model
{
    protected $table = 'genres';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'genre_url',
    ];

    public function shows(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Show');
    }
}
