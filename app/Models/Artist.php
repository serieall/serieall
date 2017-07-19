<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Artist
 *
 * @property int $id
 * @property string $name
 * @property string $artist_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereArtistUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Artist extends Model {

	protected $table = 'artists';
	public $timestamps = true;
	protected $fillable = array('name', 'artist_url');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function episodes()
	{
		return $this->morphedByMany('App\Models\Episode', 'artistable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function shows()
	{
		return $this->morphedByMany('App\Models\Show', 'artistable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function articles()
	{
		return $this->morphToMany('App\Models\Article', 'articlable');
	}

}