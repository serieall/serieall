<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->string('thumb')->nullable()->index();
            $table->boolean('spoiler')->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('commentable_id');
            $table->string('commentable_type');
            $table->timestamps();
            $table->index('created_at');
            $table->index('commentable_type');
        });
    }

    public function down()
    {
        Schema::drop('comments');
    }
}
