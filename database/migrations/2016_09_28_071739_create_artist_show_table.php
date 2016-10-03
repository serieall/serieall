<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistShowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_show', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('artist_id')->unsigned();
            $table->integer('show_id')->unsigned();
            $table->enum('profession', ['creator', 'writer', 'director', 'actor']);
            $table->foreign('artist_id')->references('id')->on('artists')
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
        Schema::table('artist_show', function (Blueprint $table){
            $table->dropForeign('artist_show_artist_id_foreign');
            $table->dropForeign('artist_show_show_id_foreign');
        });

        Schema::Drop('artist_show');
    }
}
