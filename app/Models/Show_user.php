<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Show_user.
 *
 * @property int show_id
 * @property int user_id
 * @property int state
 * @property string message
 */
class Show_user extends Model
{
    protected $table = 'show_user';
    public $timestamps = false;
    protected $fillable = [
        'show_id',
        'user_id',
        'state',
        'message',
    ];
}
