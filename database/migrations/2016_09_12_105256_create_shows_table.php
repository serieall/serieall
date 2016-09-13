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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('thetvdb_id');
            $table->string('name');
            $table->string('synopsis');
            $table->integer('format');
            $table->boolean('annee')->default(false);
            $table->boolean('encours')->default(false);
            $table->text('createurs');
            $table->tinyInteger('titre_fr');
            $table->string('diffusion_us', 100);
            $table->string('diffusion_fr', 100);
            $table->string('img', 100);
            $table->string('moyenne', 30);
            $table->string('moyenne_redac', 30);
            $table->string('nbnotes', 30);
            $table->string('taux_erectile', 30);
            $table->string('avis_rentree', 30);
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
        Schema::drop('shows');
    }
}
