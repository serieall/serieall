<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll_user extends Model {

	protected $table = 'poll_user';
	public $timestamps = false;
	protected $fillable = array('poll_id', 'user_id');

}