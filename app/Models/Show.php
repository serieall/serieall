<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model {

	protected $table = 'shows';
	public $timestamps = true;

	public function seasons()
	{
		return $this->hasMany('App\Models\Season');
	}

	public function episodes()
	{
		return $this->hasManyThrough('App\Models\Episode', '\App\Models\Season');
	}

	public function artists()
	{
		return $this->morphToMany('App\Models\Artist', 'artistable');
	}

	public function channels()
	{
		return $this->belongsToMany('App\Models\Channel');
	}

	public function nationalities()
	{
		return $this->belongsToMany('App\Models\Nationality');
	}

	public function genres()
	{
		return $this->belongsToMany('App\Models\Genre');
	}

}