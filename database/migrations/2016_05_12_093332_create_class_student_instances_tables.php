<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassStudentInstancesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_requirement_instances', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_requirement_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('file_id')->unsigned();
            $table->timestamp('submitted_at');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subject_requirement_id')->references('id')->on('subject_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subject_requirement_instances');
    }
}
