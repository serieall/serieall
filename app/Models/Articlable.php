<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Articlable.
 *
 * @property int    $article_id
 * @property int    $articlable_id
 * @property string $articlable_type
 * @property int    $id
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articlable whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articlable whereArticlableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articlable whereArticlableType($value)
 * @mixin \Eloquent
 */
class Articlable extends Model
{
    protected $table = 'articlables';
    public $timestamps = false;
    protected $fillable = ['article_id', 'articlable_id'];
}
