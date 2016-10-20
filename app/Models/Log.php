<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {

	protected $table = 'logs';
	public $timestamps = true;
	protected $fillable = array('name', 'message');

}