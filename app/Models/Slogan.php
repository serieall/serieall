<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slogan extends Model {

	protected $table = 'slogans';
	public $timestamps = true;
	protected $fillable = array('message', 'source');

}