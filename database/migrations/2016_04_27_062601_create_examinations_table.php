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
            $table->bigInteger('subject_id')->unsigned();
            $table->string('title');
            $table->integer('total_points');
            $table->dateTime('exam_start');
            $table->dateTime('exam_end');
            $table->dateTime('published_at');
            $table->boolean('is_published');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });

        Schema::create('examination_questions', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('examination_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();

            $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');        
        });

        Schema::create('examination_instances', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('examination_id')->unsigned();
            $table->dateTime('exam_start');
            $table->dateTime('exam_end');
            $table->integer('score')->nullable();
            $table->timestamp('time_started')->nullable();
            $table->timestamp('time_ended')->nullable();
            $table->string('questions_order');
            $table->boolean('is_finished');
            $table->boolean('is_recorded');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');
        });

        Schema::create('examination_answers', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('examination_instance_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('matching_type_item_id')->unsigned()->nullable();
            $table->string('answer');

            $table->foreign('examination_instance_id')->references('id')->on('examination_instances')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('matching_type_item_id')->references('id')->on('question_matching_type_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('examination_answers');
        Schema::drop('examination_instances');
        Schema::drop('examination_questions');
        Schema::drop('examinations');
    }
}
