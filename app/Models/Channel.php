<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Channel.
 *
 * @property string $name
 * @property string $channel_url
 */
class Channel extends Model
{
    protected $table = 'channels';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'channel_url',
    ];

    public function shows(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Show');
    }

    public function articles(): MorphToMany
    {
        return $this->morphToMany('App\Models\Article', 'articlable');
    }
}
