<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Show
 *
 * @property int $id
 * @property int $thetvdb_id
 * @property string $show_url
 * @property string $name
 * @property string $name_fr
 * @property string $synopsis
 * @property string $synopsis_fr
 * @property int $format
 * @property int $annee
 * @property bool $encours
 * @property string $diffusion_us
 * @property string $diffusion_fr
 * @property float $moyenne
 * @property float $moyenne_redac
 * @property int $nbnotes
 * @property int $taux_erectile
 * @property string $avis_rentree
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Season[] $seasons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Episode[] $episodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $artists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Channel[] $channels
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nationality[] $nationalities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genre[] $genres
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $creators
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $actors
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereThetvdbId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereShowUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereNameFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereSynopsis($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereSynopsisFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereFormat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereAnnee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereEncours($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereDiffusionUs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereDiffusionFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereMoyenne($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereMoyenneRedac($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereNbnotes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereTauxErectile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereAvisRentree($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $particularite
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereParticularite($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 */
class Show extends Model {

	protected $table = 'shows';
	public $timestamps = true;
	protected $fillable = ['thetvdb_id', 'show_url', 'name', 'name_fr', 'synopsis', 'synopsis_fr', 'format', 'annee', 'encours', 'diffusion_us', 'diffusion_fr', 'particularite', 'moyenne', 'moyenne_redac', 'nbnotes', 'taux_erectile', 'avis_rentree'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Season
     */
    public function seasons()
	{
		return $this->hasMany('App\Models\Season')->orderBy('name');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough|Episode
     */
    public function episodes()
	{
		return $this->hasManyThrough('App\Models\Episode', '\App\Models\Season');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function artists()
	{
		return $this->morphToMany('App\Models\Artist', 'artistable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function channels()
	{
		return $this->belongsToMany('App\Models\Channel');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nationalities()
	{
		return $this->belongsToMany('App\Models\Nationality');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres()
	{
		return $this->belongsToMany('App\Models\Genre');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
	{
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function articles()
	{
		return $this->morphToMany('App\Models\Article', 'articlable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function creators()
	{
		return $this->morphToMany('App\Models\Artist', 'artistable')->wherePivot('profession', 'creator');
	}

    /**
     * @return mixed
     */
    public function actors()
	{
		return $this->morphToMany('App\Models\Artist', 'artistable')->orderBy('name')->wherePivot('profession', 'actor')->withPivot('role');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'episode_user')->withPivot('rate', 'updated_at');
    }
}