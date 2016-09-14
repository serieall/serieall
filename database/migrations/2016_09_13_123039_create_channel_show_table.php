<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelShowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_show', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('channel_id')->unsigned();
            $table->integer('show_id')->unsigned();
            $table->foreign('channel_id')->references('id')->on('channels')
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
        Schema::table('channel_show', function (Blueprint $table){
            $table->dropForeign('channel_show_channel_id_foreign');
            $table->dropForeign('channel_show_show_id_foreign');
        });

        Schema::Drop('channel_show');
    }
}
