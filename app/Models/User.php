<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable {

	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = array('username', 'email', 'password');
	protected $hidden = array('password', 'rememberToken');

}