<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEpisodesTable extends Migration {

	public function up()
	{
		Schema::create('episodes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('thetvdb_id')->unique();
			$table->smallInteger('numero');
			$table->string('name');
			$table->string('name_fr');
			$table->text('resume');
            $table->text('resume_fr');
			$table->text('particularite');
			$table->date('diffusion_us');
			$table->date('diffusion_fr');
			$table->text('ba');
			$table->float('moyenne');
			$table->integer('nbnotes');
			$table->integer('season_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('episodes');
	}
}