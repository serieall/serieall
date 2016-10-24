<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	protected $table = 'comments';
	public $timestamps = true;
	protected $fillable = array('left', 'right', 'message', 'thumb', 'spoiler', 'parent_id', 'commentable_id', 'commentable_type');

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function commentable()
	{
		return $this->morphTo();
	}

}