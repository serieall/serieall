<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogsTable extends Migration {

	public function up()
	{
		Schema::create('logs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->index();
			$table->text('message');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('logs');
	}
}