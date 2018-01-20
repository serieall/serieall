<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Season
 *
 * @property int $id
 * @property int $thetvdb_id
 * @property int $name
 * @property string $ba
 * @property float $moyenne
 * @property int $nbnotes
 * @property int $show_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Show $show
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Episode[] $episodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereThetvdbId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereBa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereMoyenne($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereNbnotes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereShowId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Episode_user[] $users
 */
class Season extends Model {
	protected $table = 'seasons';
	public $timestamps = true;
	protected $fillable = ['thetvdb_id', 'name', 'ba', 'moyenne', 'nbnotes'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function show()
	{
		return $this->belongsTo('App\Models\Show');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Episode
     */
    public function episodes()
	{
		return $this->hasMany('App\Models\Episode')
            ->orderBy('diffusion_us')
            ->orderBy('numero');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users()
    {
        return $this->hasManyThrough('App\Models\Episode_user', 'App\Models\Episode');
    }
}