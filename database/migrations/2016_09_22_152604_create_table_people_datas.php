<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePeopleDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('people_datas')) {
            Schema::create('people_datas', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('people_id')->unsigned();
                $table->string('first_name');
                $table->string('middle_name')->nullable();
                $table->string('last_name');
                $table->string('title')->nullable();
                $table->string('suffix')->nullable();
                $table->date('birth_date')->nullable();
                $table->string('gender')->nullable();
                $table->string('nick_name')->nullable();
                $table->timestamps();
                $table->foreign('people_id')->references('id')->on('people')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('people_datas');
    }
}
