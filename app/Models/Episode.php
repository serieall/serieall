<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model {

	protected $table = 'episodes';
	public $timestamps = true;

	public function seasons()
	{
		return $this->belongsTo('App\Models\Season');
	}

	public function artists()
	{
		return $this->morphToMany('App\Models\Artist', 'artistable');
	}

}