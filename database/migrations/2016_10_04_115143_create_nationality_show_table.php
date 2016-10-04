<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNationalityShowTable extends Migration {

	public function up()
	{
		Schema::create('nationality_show', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('nationality_id')->unsigned();
			$table->integer('show_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('nationality_show');
	}
}