<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = array('username', 'email', 'password');
	protected $hidden = array('password', 'rememberToken');

}