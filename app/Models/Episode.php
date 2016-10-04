<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model {

	protected $table = 'episodes';
	public $timestamps = true;
	protected $fillable = array('thetvdb_id', 'numero', 'name', 'name_fr', 'resume', 'particularite', 'diffusion_us', 'diffusion_fr', 'ba', 'moyenne', 'nbnotes');

	public function seasons()
	{
		return $this->belongsTo('App\Models\Season');
	}

	public function artists()
	{
		return $this->morphToMany('App\Models\Artist', 'artistable');
	}

}