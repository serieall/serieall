<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article_user
 *
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article_user whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article_user whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article_user whereUserId($value)
 * @mixin \Eloquent
 */
class Article_user extends Model {

	protected $table = 'article_user';
	public $timestamps = false;
	protected $fillable = array('article_id', 'user_id');

}