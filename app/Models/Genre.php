<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Genre
 *
 * @property int $id
 * @property string $name
 * @property string $genre_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $shows
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereGenreUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Genre extends Model {

	protected $table = 'genres';
	public $timestamps = true;
	protected $fillable = array('name', 'genre_url');

	public function shows()
	{
		return $this->belongsToMany('App\Models\Show');
	}

}