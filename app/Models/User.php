<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;
	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = array('username', 'email', 'password');
	protected $hidden = array('password', 'rememberToken');

}