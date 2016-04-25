<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reporter_id')->unsigned()->default(null);
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('chat_id')->unsigned()->nullable()->default(null);
            $table->foreign('chat_id')->references('id')->on('chat')->onDelete('set null');
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
         Schema::drop('report');
    }
}
