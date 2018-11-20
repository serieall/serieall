<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShowsTable extends Migration {

	public function up()
	{
		Schema::create('shows', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('thetvdb_id')->unique()->nullable();
			$table->string('show_url')->unique();
			$table->string('name')->index();
			$table->string('name_fr')->nullable();
			$table->text('synopsis')->nullable();
			$table->text('synopsis_fr')->nullable();
			$table->integer('format');
			$table->integer('annee')->nullable();
			$table->boolean('encours');
			$table->date('diffusion_us')->nullable();
			$table->date('diffusion_fr')->nullable();
            $table->string('particularite', 255)->nullable();
			$table->float('moyenne');
			$table->float('moyenne_redac');
			$table->integer('nbnotes');
			$table->integer('taux_erectile')->nullable();
			$table->text('avis_rentree')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('shows');
	}
}