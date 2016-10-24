<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article_user extends Model {

	protected $table = 'article_user';
	public $timestamps = false;
	protected $fillable = array('article_id', 'user_id');

}