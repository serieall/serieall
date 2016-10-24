<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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