<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show_user extends Model {

	protected $table = 'show_user';
	public $timestamps = false;
	protected $fillable = array('show_id', 'user_id', 'state', 'message');

}