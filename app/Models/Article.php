<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	protected $table = 'articles';
	public $timestamps = true;
	protected $fillable = array('name', 'article_url', 'intro', 'content', 'image', 'source', 'state', 'frontpage', 'category_id');

	public function category()
	{
		return $this->belongsTo('App\Models\Category');
	}

	public function users()
	{
		return $this->belongsToMany('App\Models\User');
	}

	public function episodes()
	{
		return $this->morphedByMany('App\Models\Episode', 'articlable');
	}

	public function seasons()
	{
		return $this->morphedByMany('App\Models\Season', 'articlable');
	}

	public function shows()
	{
		return $this->morphedByMany('App\Models\Show', 'articlable');
	}

	public function artists()
	{
		return $this->morphedByMany('App\Models\Artist', 'articlable');
	}

	public function channels()
	{
		return $this->morphedByMany('App\Models\Channel', 'articlable');
	}

	public function comments()
	{
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

}