<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model {

	protected $table = 'polls';
	public $timestamps = true;
	protected $fillable = array('name', 'poll_url');

	public function questions()
	{
		return $this->hasMany('App\Models\Question');
	}

	public function users()
	{
		return $this->belongsToMany('App\Models\User');
	}

}