<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePeoplesPhones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('peoples_phones')) {
            Schema::create('peoples_phones', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('person_id')->unsigned();
                $table->integer('phone_id')->unsigned();
                $table->string('category');
                $table->timestamps();
                $table->foreign('person_id')->references('id')->on('people');
                $table->foreign('phone_id')->references('id')->on('phones');
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
        Schema::drop('peoples_phones');
    }
}
