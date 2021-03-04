<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Answer.
 *
 * @property string $name
 * @property int    $question_id
 */
class Answer extends Model
{
    protected $table = 'answers';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'question_id',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo('App\Models\Question');
    }
}
