<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Temp.
 *
 * @property int            $id
 * @property string         $key
 * @property string         $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Temp extends Model
{
    protected $table = 'temps';
    public $timestamps = true;
}
