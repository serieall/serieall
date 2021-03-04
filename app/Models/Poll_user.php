<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Poll_user.
 *
 * @property int $poll_id
 * @property int $user_id
 */
class Poll_user extends Model
{
    protected $table = 'poll_user';
    public $timestamps = false;
    protected $fillable = [
        'poll_id',
        'user_id',
    ];
}
