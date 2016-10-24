<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model {

	protected $table = 'channels';
	public $timestamps = true;
	protected $fillable = array('name', 'channel_url');

	public function shows()
	{
		return $this->belongsToMany('App\Models\Show');
	}

	public function articles()
	{
		return $this->morphToMany('App\Models\Article', 'articlable');
	}

}