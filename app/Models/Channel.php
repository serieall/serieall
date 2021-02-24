<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Channel.
 *
 * @property int                                                $id
 * @property string                                             $name
 * @property string                                             $channel_url
 * @property \Carbon\Carbon                                     $created_at
 * @property \Carbon\Carbon                                     $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|Show[]    $shows
 * @property \Illuminate\Database\Eloquent\Collection|Article[] $articles
 *
 * @method static Builder|Channel whereId($value)
 * @method static Builder|Channel whereName($value)
 * @method static Builder|Channel whereChannelUrl($value)
 * @method static Builder|Channel whereCreatedAt($value)
 * @method static Builder|Channel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Channel extends Model
{
    protected $table = 'channels';
    public $timestamps = true;
    protected $fillable = ['name', 'channel_url'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shows()
    {
        return $this->belongsToMany('App\Models\Show');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function articles()
    {
        return $this->morphToMany('App\Models\Article', 'articlable');
    }
}
