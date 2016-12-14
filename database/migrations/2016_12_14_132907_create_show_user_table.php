<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShowUserTable extends Migration {

	public function up()
	{
		Schema::create('show_user', function(Blueprint $table) {
			$table->integer('show_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->tinyInteger('state');
			$table->text('message')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('show_user');
	}
}