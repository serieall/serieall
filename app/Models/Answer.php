<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {

	protected $table = 'answers';
	public $timestamps = true;
	protected $fillable = array('name', 'question_id');

	public function question()
	{
		return $this->belongsTo('App\Models\Question');
	}

}