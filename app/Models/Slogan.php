<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slogan.
 *
 * @property string $message
 * @property string $source
 * @property string $url
 */
class Slogan extends Model
{
    protected $table = 'slogans';
    public $timestamps = true;
    protected $fillable = [
        'message',
        'source',
        'url',
    ];
}
