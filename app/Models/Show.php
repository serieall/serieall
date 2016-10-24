<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model {

	protected $table = 'shows';
	public $timestamps = true;
	protected $fillable = array('thetvdb_id', 'show_url', 'name', 'name_fr', 'synopsis', 'format', 'annee', 'encours', 'diffusion_us', 'diffusion_fr', 'moyenne', 'moyenne_redac', 'nbnotes', 'taux_erectile', 'avis_rentree');

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

	public function comments()
	{
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

	public function articles()
	{
		return $this->morphToMany('App\Models\Article', 'articlable');
	}

}