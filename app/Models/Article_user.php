<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article_user.
 *
 * @property int $article_id
 * @property int $user_id
 * @property int $id
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article_user whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article_user whereUserId($value)
 * @mixin \Eloquent
 */
class Article_user extends Model
{
    protected $table = 'article_user';
    public $timestamps = false;
    protected $fillable = ['article_id', 'user_id'];
}
