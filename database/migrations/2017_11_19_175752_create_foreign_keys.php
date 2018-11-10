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
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('parent_id')->references('id')->on('comments')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('show_user', function(Blueprint $table) {
			$table->foreign('userid')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('show_user', function(Blueprint $table) {
			$table->foreign('show_id')->references('id')->on('shows')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('episode_user', function(Blueprint $table) {
			$table->foreign('episode_id')->references('id')->on('episodes')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('episode_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('article_user', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('article_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('articlables', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('questions', function(Blueprint $table) {
			$table->foreign('poll_id')->references('id')->on('polls')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('answers', function(Blueprint $table) {
			$table->foreign('question_id')->references('id')->on('questions')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('poll_user', function(Blueprint $table) {
			$table->foreign('poll_id')->references('id')->on('polls')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('poll_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('logs', function(Blueprint $table) {
			$table->foreign('list_log_id')->references('id')->on('list_logs')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('list_logs', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
        Schema::table('contacts', function(Blueprint $table) {
            $table->foreign('admin_id')->references('id')->on('users')
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
		Schema::table('comments', function(Blueprint $table) {
			$table->dropForeign('comments_user_id_foreign');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->dropForeign('comments_parent_id_foreign');
		});
		Schema::table('show_user', function(Blueprint $table) {
			$table->dropForeign('show_user_show_id_foreign');
		});
		Schema::table('show_user', function(Blueprint $table) {
			$table->dropForeign('show_user_user_id_foreign');
		});
		Schema::table('episode_user', function(Blueprint $table) {
			$table->dropForeign('episode_user_episode_id_foreign');
		});
		Schema::table('episode_user', function(Blueprint $table) {
			$table->dropForeign('episode_user_user_id_foreign');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->dropForeign('articles_category_id_foreign');
		});
		Schema::table('article_user', function(Blueprint $table) {
			$table->dropForeign('article_user_article_id_foreign');
		});
		Schema::table('article_user', function(Blueprint $table) {
			$table->dropForeign('article_user_user_id_foreign');
		});
		Schema::table('articlables', function(Blueprint $table) {
			$table->dropForeign('articlables_article_id_foreign');
		});
		Schema::table('questions', function(Blueprint $table) {
			$table->dropForeign('questions_poll_id_foreign');
		});
		Schema::table('answers', function(Blueprint $table) {
			$table->dropForeign('answers_question_id_foreign');
		});
		Schema::table('poll_user', function(Blueprint $table) {
			$table->dropForeign('poll_user_poll_id_foreign');
		});
		Schema::table('poll_user', function(Blueprint $table) {
			$table->dropForeign('poll_user_user_id_foreign');
		});
		Schema::table('logs', function(Blueprint $table) {
			$table->dropForeign('logs_list_log_id_foreign');
		});
		Schema::table('list_logs', function(Blueprint $table) {
			$table->dropForeign('list_logs_user_id_foreign');
		});
        Schema::table('contacts', function(Blueprint $table) {
            $table->dropForeign('contacts_user_id_foreign');
        });
	}
}