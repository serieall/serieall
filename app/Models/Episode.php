<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

/**
 * App\Models\Episode.
 *
 * @property int    $thetvdb_id
 * @property int    $tmdb_id
 * @property int    $numero
 * @property string $name
 * @property string $name_fr
 * @property string $resume
 * @property string $resume_fr
 * @property string $particularite
 * @property string $diffusion_us
 * @property string $diffusion_fr
 * @property string $ba
 * @property float  $moyenne
 * @property int    $nbnotes
 * @property int    $season_id
 */
class Episode extends Model
{
    use BelongsToThroughTrait;

    protected $table = 'episodes';
    public $timestamps = true;
    protected $fillable = [
        'thetvdb_id',
        'tmdb_id',
        'numero',
        'name',
        'name_fr',
        'resume',
        'resume_fr',
        'diffusion_us',
        'diffusion_fr',
        'ba',
        'moyenne',
        'nbnotes',
        ];

    public function show(): BelongsToThrough
    {
        return $this->belongsToThrough(Show::class, Season::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo('App\Models\Season');
    }

    public function artists(): MorphToMany
    {
        return $this->morphToMany('App\Models\Artist', 'artistable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User')->withPivot('rate', 'created_at', 'updated_at');
    }

    public function articles(): MorphToMany
    {
        return $this->morphToMany('App\Models\Article', 'articlable');
    }

    public function directors(): MorphToMany
    {
        return $this->morphToMany('App\Models\Artist', 'artistable')->wherePivot('profession', 'director');
    }

    public function writers(): MorphToMany
    {
        return $this->morphToMany('App\Models\Artist', 'artistable')->wherePivot('profession', 'writer');
    }

    public function guests(): MorphToMany
    {
        return $this->morphToMany('App\Models\Artist', 'artistable')->wherePivot('profession', 'guest');
    }
}
