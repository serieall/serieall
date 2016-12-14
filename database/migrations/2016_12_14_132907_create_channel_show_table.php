<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChannelShowTable extends Migration {

	public function up()
	{
		Schema::create('channel_show', function(Blueprint $table) {
			$table->integer('channel_id')->unsigned();
			$table->integer('show_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('channel_show');
	}
}