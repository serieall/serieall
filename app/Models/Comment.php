<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $left
 * @property int $right
 * @property string $message
 * @property string $thumb
 * @property bool $spoiler
 * @property int $user_id
 * @property int $parent_id
 * @property int $commentable_id
 * @property int $commentable_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property mixed $reactions
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereThumb($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereSpoiler($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Comment extends Model {

	protected $table = 'comments';
	public $timestamps = true;
	protected $fillable = ['message', 'thumb', 'spoiler', 'parent_id', 'commentable_id', 'commentable_type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Comment', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
	{
		return $this->morphTo();
	}

}