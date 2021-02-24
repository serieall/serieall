<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slogan.
 *
 * @property int            $id
 * @property string         $message
 * @property string         $source
 * @property string         $url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Slogan extends Model
{
    protected $table = 'slogans';
    public $timestamps = true;
    protected $fillable = ['message', 'source'];
}
