<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\List_log.
 *
 * @property string $job
 * @property string $object
 * @property int    $object_id
 * @property int    $user_id
 */
class List_log extends Model
{
    protected $table = 'list_logs';
    public $timestamps = true;
    protected $fillable = [
        'job',
        'object',
        'object_id',
        'user_id',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany('App\Models\Log');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
