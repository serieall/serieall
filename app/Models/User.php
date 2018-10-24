<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $user_url
 * @property string $email
 * @property string $password
 * @property bool $role
 * @property bool $suspended
 * @property bool $activated
 * @property string $edito
 * @property bool $antispoiler
 * @property string $website
 * @property string $twitter
 * @property string $facebook
 * @property string $ip
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $shows
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Episode[] $episodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Poll[] $polls
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\List_log[] $logs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUserUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSuspended($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereActivated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEdito($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAntispoiler($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereTwitter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
class User extends Authenticatable {

    use Notifiable;

	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = ['username', 'user_url', 'email', 'password', 'role', 'suspended', 'activated', 'edito', 'antispoiler', 'website', 'twitter', 'facebook', 'ip', 'rememberToken'];
	protected $hidden = ['password', 'rememberToken'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
	{
		return $this->hasMany('App\Models\Comment');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shows()
	{
		return $this->belongsToMany('App\Models\Show');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function episodes()
	{
		return $this->belongsToMany('App\Models\Episode')->withPivot('rate', 'updated_at');
	}

	public function rates()
    {
        return $this->belongsToMany('App\Models\Episode');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
	{
		return $this->belongsToMany('App\Models\Article');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function polls()
	{
		return $this->belongsToMany('App\Models\Poll');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
	{
		return $this->hasMany('App\Models\List_log');
	}

}