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
            $table->bigInteger('user_id')->unsigned();
            $table->string('subcategory');
            $table->string('description');
            $table->integer('total_points');
            $table->integer('quarter');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('examination_parts', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('examination_id')->unsigned();
            $table->bigInteger('question_type_id')->unsigned();
            $table->integer('points');
            $table->integer('questions_quantity');
            
            $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');
            $table->foreign('question_type_id')->references('id')->on('question_types')->onDelete('cascade');
        });

        Schema::create('examination_part_items', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('examination_part_id')->unsigned();
            $table->bigInteger('question_subtopic_id')->unsigned();
            $table->integer('quantity');
            $table->integer('choices_quantity')->nullable();
            $table->bigInteger('question_id')->unsigned()->nullable();

            $table->foreign('examination_part_id')->references('id')->on('examination_parts')->onDelete('cascade');
            $table->foreign('question_subtopic_id')->references('id')->on('question_subtopics')->onDelete('cascade'); 
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::create('deployments', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('examination_id')->unsigned();
            $table->bigInteger('grade_section_subject_id')->unsigned();
            $table->dateTime('publish_on');
            $table->dateTime('exam_start');
            $table->dateTime('exam_end');

            $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');
            $table->foreign('grade_section_subject_id')->references('id')->on('grade_section_subjects')->onDelete('cascade');
        });

        Schema::create('deployment_instances', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('deployment_id')->unsigned()->nullable();
            $table->integer('score')->nullable();
            $table->timestamp('time_started')->nullable();
            $table->timestamp('time_ended')->nullable();
            $table->boolean('is_finished');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('deployment_id')->references('id')->on('deployments')->onDelete('cascade');
        });

        Schema::create('deployment_instance_parts', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('deployment_instance_id')->unsigned();
            $table->bigInteger('examination_part_id')->unsigned();
            $table->string('question_order');
        
            $table->foreign('deployment_instance_id')->references('id')->on('deployment_instances')->onDelete('cascade');
            $table->foreign('examination_part_id')->references('id')->on('examination_parts')->onDelete('cascade');
        });

        Schema::create('deployment_answers', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('deployment_instance_part_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('wordbox_item_id')->unsigned()->nullable();
            $table->bigInteger('columns_item_id')->unsigned()->nullable();
            $table->string('answer');

            $table->foreign('deployment_instance_part_id')->references('id')->on('deployment_instance_parts')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('wordbox_item_id')->references('id')->on('question_select_from_the_wordbox_items')->onDelete('cascade');
            $table->foreign('columns_item_id')->references('id')->on('question_match_columns_items')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deployment_answers');
        Schema::drop('deployment_instance_parts');
        Schema::drop('deployment_instances');
        Schema::drop('deployments');
        Schema::drop('examination_part_items');
        Schema::drop('examination_parts');
        Schema::drop('examinations');
    }
}
