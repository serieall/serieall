<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShowsTable extends Migration {

	public function up()
	{
		Schema::create('shows', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('thetvdb_id')->unique();
			$table->string('show_url')->unique();
			$table->string('name')->index();
			$table->string('name_fr');
			$table->text('synopsis');
            $table->text('synopsis_fr');
			$table->integer('format');
			$table->integer('annee');
			$table->boolean('encours');
			$table->date('diffusion_us');
			$table->date('diffusion_fr');
			$table->float('moyenne');
			$table->float('moyenne_redac');
			$table->integer('nbnotes');
			$table->integer('taux_erectile');
			$table->text('avis_rentree');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('shows');
	}
}