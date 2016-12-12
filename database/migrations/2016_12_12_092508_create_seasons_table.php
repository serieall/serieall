<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeasonsTable extends Migration {

	public function up()
	{
		Schema::create('seasons', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('thetvdb_id')->unique()->nullable();
			$table->smallInteger('name');
			$table->text('ba');
			$table->float('moyenne');
			$table->integer('nbnotes');
			$table->integer('show_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('seasons');
	}
}