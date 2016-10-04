<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistablesTable extends Migration {

	public function up()
	{
		Schema::create('artistables', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('artist_id')->unsigned();
			$table->integer('artistable_id');
			$table->string('artistable_type');
			$table->enum('profession', array('creator', 'writer', 'director', 'actor', 'guest'));
		});
	}

	public function down()
	{
		Schema::drop('artistables');
	}
}