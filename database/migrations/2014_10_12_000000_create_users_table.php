<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('pseudo');
            $table->string('email')->unique();
            $table->string('avatar')->default("default.jpg");
            $table->string('description');
            $table->string('password');
            $table->integer('warnings')->default(0);
            $table->boolean('isAdmin')->default(false);
            $table->boolean('isVoice')->default(false);
            $table->boolean('isColor')->default(true);
            $table->boolean('isBlocked')->default(false);
            $table->integer('fontSize')->default(100);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
