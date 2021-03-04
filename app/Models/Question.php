<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Question.
 *
 * @property string $name
 * @property int    $poll_id
 */
class Question extends Model
{
    protected $table = 'questions';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'poll_id',
    ];

    public function poll(): BelongsTo
    {
        return $this->belongsTo('App\Models\Poll');
    }

    public function answers(): HasMany
    {
        return $this->hasMany('App\Models\Answer');
    }
}
