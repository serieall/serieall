<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Channel_show.
 *
 * @property int $channel_id
 * @property int $show_id
 */
class Channel_show extends Model
{
    protected $table = 'channel_show';
    public $timestamps = false;
}
