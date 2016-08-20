<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('role')->default(1);
            $table->tinyInteger('suspendu')->default(0);
            $table->tinyInteger('desactive')->default(0);
            $table->text('edito');
            $table->tinyInteger('antispoiler');
            $table->string('website', 100);
            $table->string('twitter', 100);
            $table->string('facebook', 100);
            $table->string('ip', 30);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
