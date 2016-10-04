<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model {

	protected $table = 'nationalities';
	public $timestamps = true;
	protected $fillable = array('name', 'nationality_url');

	public function shows()
	{
		return $this->belongsToMany('App\Models\Show');
	}

}