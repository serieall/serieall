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
 * @property int    $id
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereArtistableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereArtistableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereProfession($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereRole($value)
 * @mixin \Eloquent
 */
class Artistable extends Model
{
    protected $table = 'artistables';
    public $timestamps = false;
}
