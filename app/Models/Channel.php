<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Channel
 *
 * @property int $id
 * @property string $name
 * @property string $channel_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $shows
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereChannelUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Channel extends Model {

	protected $table = 'channels';
	public $timestamps = true;
	protected $fillable = array('name', 'channel_url');

	public function shows()
	{
		return $this->belongsToMany('App\Models\Show');
	}

	public function articles()
	{
		return $this->morphToMany('App\Models\Article', 'articlable');
	}

}