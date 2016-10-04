<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('seasons', function(Blueprint $table) {
			$table->foreign('show_id')->references('id')->on('shows')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('episodes', function(Blueprint $table) {
			$table->foreign('season_id')->references('id')->on('seasons')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('artistables', function(Blueprint $table) {
			$table->foreign('artist_id')->references('id')->on('artists')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('channel_show', function(Blueprint $table) {
			$table->foreign('channel_id')->references('id')->on('channels')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('channel_show', function(Blueprint $table) {
			$table->foreign('show_id')->references('id')->on('shows')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('nationality_show', function(Blueprint $table) {
			$table->foreign('nationality_id')->references('id')->on('nationalities')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('nationality_show', function(Blueprint $table) {
			$table->foreign('show_id')->references('id')->on('shows')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('genre_show', function(Blueprint $table) {
			$table->foreign('genre_id')->references('id')->on('genres')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('genre_show', function(Blueprint $table) {
			$table->foreign('show_id')->references('id')->on('shows')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('seasons', function(Blueprint $table) {
			$table->dropForeign('seasons_show_id_foreign');
		});
		Schema::table('episodes', function(Blueprint $table) {
			$table->dropForeign('episodes_season_id_foreign');
		});
		Schema::table('artistables', function(Blueprint $table) {
			$table->dropForeign('artistables_artist_id_foreign');
		});
		Schema::table('channel_show', function(Blueprint $table) {
			$table->dropForeign('channel_show_channel_id_foreign');
		});
		Schema::table('channel_show', function(Blueprint $table) {
			$table->dropForeign('channel_show_show_id_foreign');
		});
		Schema::table('nationality_show', function(Blueprint $table) {
			$table->dropForeign('nationality_show_nationality_id_foreign');
		});
		Schema::table('nationality_show', function(Blueprint $table) {
			$table->dropForeign('nationality_show_show_id_foreign');
		});
		Schema::table('genre_show', function(Blueprint $table) {
			$table->dropForeign('genre_show_genre_id_foreign');
		});
		Schema::table('genre_show', function(Blueprint $table) {
			$table->dropForeign('genre_show_show_id_foreign');
		});
	}
}