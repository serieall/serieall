<?php

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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereThetvdbId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereShowUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereNameFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereSynopsis($value)
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
 */
class Show extends Model {

	protected $table = 'shows';
	public $timestamps = true;
	protected $fillable = array('thetvdb_id', 'show_url', 'name', 'name_fr', 'synopsis', 'synopsis_fr', 'format', 'annee', 'encours', 'diffusion_us', 'diffusion_fr', 'moyenne', 'moyenne_redac', 'nbnotes', 'taux_erectile', 'avis_rentree');

	public function seasons()
	{
		return $this->hasMany('App\Models\Season');
	}

	public function episodes()
	{
		return $this->hasManyThrough('App\Models\Episode', '\App\Models\Season');
	}

	public function artists()
	{
		return $this->morphToMany('App\Models\Artist', 'artistable');
	}

	public function channels()
	{
		return $this->belongsToMany('App\Models\Channel');
	}

	public function nationalities()
	{
		return $this->belongsToMany('App\Models\Nationality');
	}

	public function genres()
	{
		return $this->belongsToMany('App\Models\Genre');
	}

	public function comments()
	{
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

	public function articles()
	{
		return $this->morphToMany('App\Models\Article', 'articlable');
	}

}