<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User.
 *
 * @property string $username
 * @property string $user_url
 * @property string $email
 * @property bool   $role
 * @property bool   $suspended
 * @property bool   $activated
 * @property string $edito
 * @property bool   $antispoiler
 * @property string $website
 * @property string $twitter
 * @property string $facebook
 * @property string $ip
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = [
        'username',
        'user_url',
        'email',
        'password',
        'role',
        'suspended',
        'activated',
        'edito',
        'antispoiler',
        'website',
        'twitter',
        'facebook',
        'ip',
        'rememberToken',
    ];
    protected $hidden = [
        'password',
        'rememberToken',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function shows(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Show')->withPivot('state', 'message');
    }

    public function episodes(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Episode')->withPivot('rate', 'updated_at');
    }

    public function rates(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Episode');
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Article');
    }

    public function polls(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Poll');
    }

    public function logs(): HasMany
    {
        return $this->hasMany('App\Models\List_log');
    }
}
