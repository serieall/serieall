<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Comment.
 *
 * @property int    $left
 * @property int    $right
 * @property string $message
 * @property string $thumb
 * @property bool   $spoiler
 * @property int    $user_id
 * @property int    $parent_id
 * @property int    $commentable_id
 * @property int    $commentable_type
 */
class Comment extends Model
{
    protected $table = 'comments';
    public $timestamps = true;
    protected $fillable = [
        'message',
        'thumb',
        'spoiler',
        'parent_id',
        'commentable_id',
        'commentable_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function children(): HasMany
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo('App\Models\Comment', 'parent_id');
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
