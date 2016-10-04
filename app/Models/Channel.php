<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model {

	protected $table = 'channels';
	public $timestamps = true;

	public function shows()
	{
		return $this->belongsToMany('App\Models\Show');
	}

}