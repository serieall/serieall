<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User_activation.
 *
 * @property int            $user_id
 * @property string         $token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int            $id
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_activation whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_activation whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_activation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_activation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User_activation extends Model
{
    protected $table = 'user_activations';
    public $timestamps = true;
}
