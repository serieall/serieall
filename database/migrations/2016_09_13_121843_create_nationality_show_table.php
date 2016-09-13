<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNationalityShowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nationality_show', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nationality_id')->unsigned();
            $table->integer('show_id')->unsigned();
            $table->foreign('nationality_id')->references('id')->on('nationalities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('show_id')->references('id')->on('shows')
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
        Schema::table('nationality_show', function (Blueprint $table){
            $table->dropForeign('nationality_show_nationality_id_foreign');
            $table->dropForeign('nationality_show_show_id_foreign');
        });

        Schema::Drop('nationality_show');
    }
}
