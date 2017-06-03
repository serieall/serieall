<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogsTable extends Migration {

	public function up()
	{
		Schema::create('logs', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('list_log_id')->unsigned();
			$table->text('message');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('logs');
	}
}