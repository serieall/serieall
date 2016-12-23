<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGenreShowTable extends Migration {

	public function up()
	{
		Schema::create('genre_show', function(Blueprint $table) {
			$table->integer('genre_id')->unsigned();
			$table->integer('show_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('genre_show');
	}
}