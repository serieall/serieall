<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEpisodesTable extends Migration {

	public function up()
	{
		Schema::create('episodes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('thetvdb_id')->unique()->nullable();
			$table->smallInteger('numero');
			$table->string('name')->nullable();
			$table->string('name_fr')->nullable();
			$table->text('resume')->nullable();
			$table->text('resume_fr')->nullable();
			$table->text('particularite')->nullable();
			$table->date('diffusion_us')->nullable();
			$table->date('diffusion_fr')->nullable();
			$table->text('ba')->nullable();
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