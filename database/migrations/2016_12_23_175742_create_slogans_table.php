<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlogansTable extends Migration {

	public function up()
	{
		Schema::create('slogans', function(Blueprint $table) {
			$table->increments('id');
			$table->text('message');
			$table->string('source')->nullable();
			$table->string('url')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('slogans');
	}
}