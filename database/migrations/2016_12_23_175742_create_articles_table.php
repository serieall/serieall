<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

	public function up()
	{
		Schema::create('articles', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('article_url');
			$table->text('intro');
			$table->text('content');
			$table->string('image')->nullable();
			$table->string('source')->nullable();
			$table->tinyInteger('state')->default('0');
			$table->boolean('frontpage')->default(0);
			$table->integer('category_id')->unsigned();
			$table->timestamp('published_at')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('articles');
	}
}