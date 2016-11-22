<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model {

	protected $table = 'episodes';
	public $timestamps = true;
	protected $fillable = array('thetvdb_id', 'numero', 'name', 'name_fr', 'resume', 'resume_fr', 'particularite', 'diffusion_us', 'diffusion_fr', 'ba', 'moyenne', 'nbnotes');

	public function season()
	{
		return $this->belongsTo('App\Models\Season');
	}

	public function artists()
	{
		return $this->morphToMany('App\Models\Artist', 'artistable');
	}

	public function comments()
	{
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

	public function users()
	{
		return $this->belongsToMany('App\Models\User');
	}

	public function articles()
	{
		return $this->morphToMany('App\Models\Article', 'articlable');
	}

}