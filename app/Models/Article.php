<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Article.
 *
 * @property Carbon $published_at
 * @property string $name
 * @property string $article_url
 * @property string $intro
 * @property string $content
 * @property string $image
 * @property string $source
 * @property bool   $state
 * @property bool   $frontpage
 * @property int    $category_id
 */
class Article extends Model
{
    protected $table = 'articles';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'article_url',
        'intro',
        'content',
        'image',
        'source',
        'state',
        'frontpage',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function episodes(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Episode', 'articlable');
    }

    public function seasons(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Season', 'articlable');
    }

    public function shows(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Show', 'articlable');
    }

    public function artists(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Artist', 'articlable');
    }

    public function channels(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Channel', 'articlable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
