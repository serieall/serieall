<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Nationality.
 *
 * @property string $name
 * @property string $nationality_url
 */
class Nationality extends Model
{
    protected $table = 'nationalities';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'nationality_url',
    ];

    public function shows(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Show');
    }
}
