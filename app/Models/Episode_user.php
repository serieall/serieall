<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

/**
 * App\Models\Episode_user.
 *
 * @property int $episode_id
 * @property int $user_id
 * @property int $rate
 */
class Episode_user extends Model
{
    use HasEagerLimit;

    protected $table = 'episode_user';
    public $timestamps = true;
    protected $fillable = [
        'episode_id',
        'user_id',
        'rate',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function episode(): BelongsTo
    {
        return $this->belongsTo('App\Models\Episode', 'episode_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
