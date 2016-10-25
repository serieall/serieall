<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlablesTable extends Migration {

	public function up()
	{
		Schema::create('articlables', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('article_id')->unsigned();
			$table->integer('articlable_id');
			$table->string('articlable_type');
		});
	}

	public function down()
	{
		Schema::drop('articlables');
	}
}