<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Artistable.
 *
 * @property int    $artist_id
 * @property int    $artistable_id
 * @property string $artistable_type
 * @property string $profession
 * @property string $role
 */
class Artistable extends Model
{
    protected $table = 'artistables';
    public $timestamps = false;
}
