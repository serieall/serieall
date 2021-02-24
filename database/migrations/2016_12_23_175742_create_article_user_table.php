<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleUserTable extends Migration
{
    public function up()
    {
        Schema::create('article_user', function (Blueprint $table) {
            $table->integer('article_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::drop('article_user');
    }
}
