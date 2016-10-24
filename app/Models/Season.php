<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model {

	protected $table = 'seasons';
	public $timestamps = true;
	protected $fillable = array('thetvdb_id', 'name', 'ba', 'moyenne', 'nbnotes');

	public function show()
	{
		return $this->belongsTo('App\Models\Show');
	}

	public function episodes()
	{
		return $this->hasMany('App\Models\Episode');
	}

	public function comments()
	{
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

	public function articles()
	{
		return $this->morphToMany('App\Models\Article', 'articlable');
	}

}