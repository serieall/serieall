<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Channel_show.
 *
 * @property int $channel_id
 * @property int $show_id
 * @property int $id
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel_show whereChannelId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel_show whereShowId($value)
 * @mixin \Eloquent
 */
class Channel_show extends Model
{
    protected $table = 'channel_show';
    public $timestamps = false;
}
