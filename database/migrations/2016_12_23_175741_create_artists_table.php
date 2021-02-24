<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistsTable extends Migration
{
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('artist_url')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('artists');
    }
}
