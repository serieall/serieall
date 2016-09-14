<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('thetvdb_id');
            $table->tinyInteger('name');
            $table->text('ba');
            $table->float('moyenne');
            $table->integer('nbnotes');
            $table->timestamps();
            $table->integer('show_id')->unsigned();
            $table->foreign('show_id')
                ->references('id')
                ->on('shows')
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
        Schema::Drop('seasons');
    }
}
