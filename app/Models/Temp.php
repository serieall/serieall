<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Temp.
 *
 * @property string $key
 * @property string $value
 */
class Temp extends Model
{
    protected $table = 'temps';
    public $timestamps = true;
}
