<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rateValue');
            $table->string('description');
            $table->double('longitude');
            $table->double('latitude');
            $table->integer('type_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('isValidate');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('type_id')
                ->references('id')
                ->on('types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('points');
    }
}
