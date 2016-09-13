<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowsTable extends Migration
{
    /** 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thetvdb_id');
            $table->string('show_url')->unique();
            $table->string('name');
            $table->string('name_fr');
            $table->text('synopsis');
            $table->integer('format',4);
            $table->integer('annee', 4);
            $table->tinyInteger('encours');
            $table->text('createurs');
            $table->date('diffusion_us');
            $table->date('diffusion_fr');
            $table->float('moyenne');
            $table->float('moyenne_redac');
            $table->integer('nbnotes');
            $table->integer('taux_erectile', 2);
            $table->text('avis_rentree');
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
        Schema::drop('shows');
    }
}
