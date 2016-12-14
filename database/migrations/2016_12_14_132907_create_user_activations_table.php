<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserActivationsTable extends Migration {

	public function up()
	{
		Schema::create('user_activations', function(Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->string('token')->index();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('user_activations');
	}
}