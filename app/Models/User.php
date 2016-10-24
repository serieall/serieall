<?php

namespace App\Models;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable {
    use Notifiable;

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = array('username', 'user_url', 'email', 'password', 'role', 'suspended', 'activated', 'edito', 'antispoiler', 'website', 'twitter', 'facebook', 'ip', 'rememberToken');
	protected $hidden = array('password', 'rememberToken');

	public function comments()
	{
		return $this->hasMany('App\Models\Comment');
	}

	public function shows()
	{
		return $this->belongsToMany('App\Models\Show');
	}

	public function episodes()
	{
		return $this->belongsToMany('App\Models\Episode');
	}

	public function articles()
	{
		return $this->belongsToMany('App\Models\Article');
	}

	public function polls()
	{
		return $this->belongsToMany('App\Models\Poll');
	}

}