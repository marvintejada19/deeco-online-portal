<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examinations', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_category_id')->unsigned();
            $table->bigInteger('subject_category_instance_id')->unsigned();
            $table->string('name');
            $table->integer('total_points');
            $table->string('date_created');

            $table->foreign('subject_category_id')->references('id')->on('subject_categorys')->onDelete('cascade');
            $table->foreign('subject_category_instance_id')->references('id')->on('subject_category_instances')->onDelete('cascade');
        });

        Schema::create('examination_instances', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('examination_id')->unsigned();
            $table->integer('score');
            $table->timestamp('time_taken');
            $table->time('exam_start');
            $table->time('exam_end');
            $table->boolean('is_recorded');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('examination_instances');
        Schema::drop('examinations');
    }
}
