<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Category.
 *
 * @property string $name
 * @property string $description
 */
class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'description',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany('App\Models\Article');
    }
}
