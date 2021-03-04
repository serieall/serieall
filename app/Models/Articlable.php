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
 */
class Articlable extends Model
{
    protected $table = 'articlables';
    public $timestamps = false;
    protected $fillable = [
        'article_id',
        'articlable_id',
        'articlable_type',
    ];
}
