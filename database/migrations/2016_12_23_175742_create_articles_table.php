<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 255);
            $table->string('article_url', 255);
            $table->text('intro');
            $table->mediumText('content');
            $table->string('image', 255)->nullable();
            $table->string('source', 255)->nullable();
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
