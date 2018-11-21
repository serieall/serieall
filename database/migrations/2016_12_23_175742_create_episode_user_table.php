<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEpisodeUserTable extends Migration {

	public function up()
	{
		Schema::create('episode_user', function(Blueprint $table) {
			$table->integer('episode_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->smallInteger('rate');
			$table->timestamps();
			$table->index('created_at');
		});
	}

	public function down()
	{
		Schema::drop('episode_user');
	}
}