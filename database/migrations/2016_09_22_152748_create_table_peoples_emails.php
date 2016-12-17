<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePeoplesEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('peoples_emails')) {
            Schema::create('peoples_emails', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('person_id')->unsigned();
                $table->integer('email_id')->unsigned();
                $table->timestamps();
                $table->foreign('person_id')->references('id')->on('people');
                $table->foreign('email_id')->references('id')->on('emails');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('peoples_emails');
    }
}
