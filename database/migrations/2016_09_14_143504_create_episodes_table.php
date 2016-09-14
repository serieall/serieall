<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('thetvdb_id');
            $table->smallInteger('numero');
            $table->string('name');
            $table->string('name_fr');
            $table->text('resume');
            $table->text('particularite');
            $table->date('diffusion_us');
            $table->date('diffusion_fr');
            $table->string('guests');
            $table->text('ba');
            $table->float('moyenne');
            $table->integer('nbnotes');
            $table->timestamps();
            $table->integer('season_id')->unsigned();
            $table->foreign('season_id')
                ->references('id')
                ->on('seasons')
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
        Schema::Drop('episodes');
    }
}
