<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollsTable extends Migration {

	public function up()
	{
		Schema::create('polls', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('poll_url');
		});
	}

	public function down()
	{
		Schema::drop('polls');
	}
}