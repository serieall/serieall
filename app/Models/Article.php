<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $published_at
 * @property string $name
 * @property string $article_url
 * @property string $intro
 * @property string $content
 * @property string $image
 * @property string $source
 * @property bool $state
 * @property bool $frontpage
 * @property int $category_id
 * @property mixed $episodes
 * @property mixed $seasons
 * @property mixed $artists
 * @property mixed $shows
 * @property mixed $channels
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereArticleUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereFrontpage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereCategoryId($value)
 * @mixin \Eloquent
 */
class Article extends Model {

	protected $table = 'articles';
	public $timestamps = true;
	protected $fillable = ['name', 'article_url', 'intro', 'content', 'image', 'source', 'state', 'frontpage', 'category_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
	{
		return $this->belongsTo('App\Models\Category');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
	{
		return $this->belongsToMany('App\Models\User');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function episodes()
	{
		return $this->morphedByMany('App\Models\Episode', 'articlable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function seasons()
	{
		return $this->morphedByMany('App\Models\Season', 'articlable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function shows()
	{
		return $this->morphedByMany('App\Models\Show', 'articlable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function artists()
	{
		return $this->morphedByMany('App\Models\Artist', 'articlable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function channels()
	{
		return $this->morphedByMany('App\Models\Channel', 'articlable');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
	{
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

    public function toFeedItem()
    {
        return FeedItem::create()
            ->id((string)$this->id)
            ->title($this->name)
            ->summary($this->intro)
            ->updated($this->updated_at)
            ->link(route('article.show', $this->article_url))
            ->author('toto');
    }

    public static function getFeedItems()
    {
        return Article::where('podcast', '=', true)->get();
    }

}