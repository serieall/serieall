<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Episode_user
 *
 * @property int $episode_id
 * @property int $user_id
 * @property int $rate
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode_user whereEpisodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode_user whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode_user whereRate($value)
 * @mixin \Eloquent
 * @property int|null $season_id
 * @property int|null $show_id
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Episode $episode
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Episode_user whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Episode_user whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Episode_user whereUpdatedAt($value)
 */
class Episode_user extends Model {

	protected $table = 'episode_user';
	public $timestamps = true;
	protected $fillable = array('episode_id', 'user_id', 'rate');
    protected $dates = ['created_at', 'updated_at'];

	public function episode()
    {
        return $this->belongsTo('App\Models\Episode', 'episode_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}