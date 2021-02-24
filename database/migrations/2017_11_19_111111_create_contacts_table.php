<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('objet');
            $table->text('message');
            $table->integer('admin_id')->unsigned()->nullable();
            $table->text('admin_message')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('contacts');
    }
}
