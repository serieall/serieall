<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEpisodeUserTable extends Migration {

	public function up()
	{
		Schema::create('episode_user', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('episode_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->smallInteger('rate');
		});
	}

	public function down()
	{
		Schema::drop('episode_user');
	}
}