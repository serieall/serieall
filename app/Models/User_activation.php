<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User_activation.
 *
 * @property int    $user_id
 * @property string $token
 */
class User_activation extends Model
{
    protected $table = 'user_activations';
    public $timestamps = true;
}
