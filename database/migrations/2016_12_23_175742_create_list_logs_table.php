<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListLogsTable extends Migration {

	public function up()
	{
		Schema::create('list_logs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('job')->nullable()->index();
			$table->string('object')->nullable();
			$table->integer('object_id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('list_logs');
	}
}