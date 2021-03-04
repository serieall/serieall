<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Poll.
 *
 * @property string $name
 * @property string $poll_url
 */
class Poll extends Model
{
    protected $table = 'polls';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'poll_url',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany('App\Models\Question');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User');
    }
}
