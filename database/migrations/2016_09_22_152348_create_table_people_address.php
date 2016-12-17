<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePeopleAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('people_address')) {
            Schema::create('people_address', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('person_id')->unsigned();
                $table->integer('address_id')->unsigned();
                $table->timestamps();
                $table->foreign('person_id')->references('id')->on('people');
                $table->foreign('address_id')->references('id')->on('addresses');
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
        Schema::drop('people_address');
    }
}
