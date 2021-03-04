<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * Model for a TV Show.
 *
 * @property int tmdb_id
 * @property string show_url
 * @property string name
 * @property string name_fr
 * @property string synopsis
 * @property string synopsis_fr
 * @property int format
 * @property int annee
 * @property int encours
 * @property string diffusion_us
 * @property string diffusion_fr
 * @property string particularite
 * @property float moyenne
 * @property float moyenne_redac
 * @property int nbnotes
 * @property int taux_erectile
 * @property string avis_rentree
 * @property int created_at
 * @property int updated_at
 */
class Show extends Model
{
    use HasRelationships;
    use HasEagerLimit;

    protected $table = 'shows';
    public $timestamps = true;
    protected $fillable = [
        'thetvdb_id',
        'tmdb_id',
        'show_url',
        'name',
        'name_fr',
        'synopsis',
        'synopsis_fr',
        'format',
        'annee',
        'encours',
        'diffusion_us',
        'diffusion_fr',
        'particularite',
        'moyenne',
        'moyenne_redac',
        'nbnotes',
        'taux_erectile',
        'avis_rentree',
    ];

    /**
     * Return linked seasons.
     */
    public function seasons(): HasMany
    {
        return $this->hasMany('App\Models\Season')->orderBy('name');
    }

    /**
     * Return linked episodes.
     */
    public function episodes(): HasManyThrough
    {
        return $this->hasManyThrough('App\Models\Episode', '\App\Models\Season');
    }

    /**
     * Return linked artists.
     */
    public function artists(): MorphToMany
    {
        return $this->morphToMany('App\Models\Artist', 'artistable');
    }

    /**
     * Return linked channels.
     */
    public function channels(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Channel');
    }

    /**
     * Return linked nationalities.
     */
    public function nationalities(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Nationality');
    }

    /**
     * Return linked genres.
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Genre');
    }

    /**
     * Return linked comments.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    /**
     * Return linked articles.
     */
    public function articles(): MorphToMany
    {
        return $this->morphToMany('App\Models\Article', 'articlable');
    }

    /**
     * Return linked creators.
     */
    public function creators(): BelongsToMany
    {
        return $this->morphToMany('App\Models\Artist', 'artistable')->wherePivot('profession', 'creator');
    }

    /**
     * Return linked actors.
     */
    public function actors(): MorphToMany
    {
        return $this->morphToMany('App\Models\Artist', 'artistable')->orderBy('name')->wherePivot('profession', 'actor')->withPivot('role');
    }

    /**
     * Return users following the show.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User')->withPivot('state', 'message');
    }

    /**
     * Return linked episodes rates.
     */
    public function rates(): HasManyDeep
    {
        return $this->hasManyDeep('App\Models\Episode_user', ['App\Models\Season', 'App\Models\Episode'], [null]);
    }
}
