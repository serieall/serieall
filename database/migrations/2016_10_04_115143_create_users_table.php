<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('email')->unique();
			$table->string('password');
			$table->tinyInteger('role')->default('1');
			$table->boolean('suspended')->default(false);
			$table->boolean('activated')->default(false);
			$table->text('edito');
			$table->boolean('antispoiler')->default(true);
			$table->string('website');
			$table->string('twitter');
			$table->string('facebook');
			$table->string('ip');
			$table->rememberToken('rememberToken');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}