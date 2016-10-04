<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistEpisodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_episode', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('artist_id')->unsigned();
            $table->integer('episode_id')->unsigned();
            $table->enum('profession', ['writer', 'director', 'guest']);
            $table->foreign('artist_id')->references('id')->on('artists')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('episode_id')->references('id')->on('episodes')
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
        Schema::table('artist_episode', function (Blueprint $table){
            $table->dropForeign('artist_show_artist_id_foreign');
            $table->dropForeign('artist_show_episode_id_foreign');
        });

        Schema::Drop('artist_episode');
    }
}
