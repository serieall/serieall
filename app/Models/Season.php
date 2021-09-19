<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Season.
 *
 * @property int thetvdb_id
 * @property int tmdb_id
 * @property int name
 * @property string ba
 * @property float moyenne
 * @property int nbnotes
 */
class Season extends Model
{
    use HasFactory;

    protected $table = 'seasons';
    public $timestamps = true;
    protected $fillable = [
        'thetvdb_id',
        'tmdb_id',
        'name',
        'ba',
        'moyenne',
        'nbnotes',
    ];

    public function show(): BelongsTo
    {
        return $this->belongsTo('App\Models\Show');
    }

    public function episodes(): HasMany
    {
        return $this->hasMany('App\Models\Episode')
            ->orderBy('diffusion_us')
            ->orderBy('numero');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function articles(): MorphToMany
    {
        return $this->morphToMany('App\Models\Article', 'articlable');
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough('App\Models\Episode_user', 'App\Models\Episode');
    }
}
