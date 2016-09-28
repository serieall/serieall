<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreShowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_show', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('genre_id')->unsigned();
            $table->integer('show_id')->unsigned();
            $table->foreign('genre_id')->references('id')->on('genres')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('show_id')->references('id')->on('shows')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('genre_show', function (Blueprint $table){
            $table->dropForeign('genre_show_genre_id_foreign');
            $table->dropForeign('genre_show_show_id_foreign');
        });

        Schema::Drop('genre_show');
    }
}
