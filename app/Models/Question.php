<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property int $poll_id
 * @property-read \App\Models\Poll $poll
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Answer[] $answers
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question wherePollId($value)
 * @mixin \Eloquent
 */
class Question extends Model {

	protected $table = 'questions';
	public $timestamps = true;
	protected $fillable = array('name', 'poll_id');

	public function poll()
	{
		return $this->belongsTo('App\Models\Poll');
	}

	public function answers()
	{
		return $this->hasMany('App\Models\Answer');
	}

}