<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Poll
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $poll_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll wherePollUrl($value)
 * @mixin \Eloquent
 */
class Poll extends Model {

	protected $table = 'polls';
	public $timestamps = true;
	protected $fillable = array('name', 'poll_url');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
	{
		return $this->hasMany('App\Models\Question');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
	{
		return $this->belongsToMany('App\Models\User');
	}

}