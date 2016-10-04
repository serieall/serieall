<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model {

	protected $table = 'artists';
	public $timestamps = true;

	public function episodes()
	{
		return $this->morphedByMany('App\Models\Episode', 'artistable');
	}

	public function shows()
	{
		return $this->morphedByMany('App\Models\Show', 'artistable');
	}

}