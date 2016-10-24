<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode_user extends Model {

	protected $table = 'episode_user';
	public $timestamps = false;
	protected $fillable = array('episode_id', 'user_id', 'rate');

}