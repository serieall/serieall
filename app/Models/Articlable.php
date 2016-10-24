<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articlable extends Model {

	protected $table = 'articlables';
	public $timestamps = false;
	protected $fillable = array('article_id', 'articlable_id');

}