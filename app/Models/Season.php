<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model {

	protected $table = 'seasons';
	public $timestamps = true;

	public function show()
	{
		return $this->belongsTo('App\Models\Show');
	}

	public function episodes()
	{
		return $this->hasMany('App\Models\Episode');
	}

}