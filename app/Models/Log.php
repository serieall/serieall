<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Log.
 *
 * @property int    $list_log_id
 * @property string $message
 */
class Log extends Model
{
    protected $table = 'logs';
    public $timestamps = true;
    protected $fillable = [
        'list_log_id',
        'message',
    ];

    public function list_log(): BelongsTo
    {
        return $this->belongsTo('App\Models\List_log');
    }
}
