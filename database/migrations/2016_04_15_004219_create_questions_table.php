<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_types', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('title');
        });

        Schema::create('question_categories', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('title');
        });

        Schema::create('question_topics', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_category_id')->unsigned();
            $table->string('title');

            $table->foreign('question_category_id')->references('id')->on('question_categories')->onDelete('cascade');
        });

        Schema::create('question_subtopics', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_topic_id')->unsigned();
            $table->string('title');

            $table->foreign('question_topic_id')->references('id')->on('question_topics')->onDelete('cascade');
        });

        Schema::create('questions', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_type_id')->unsigned();
            $table->bigInteger('question_category_id')->unsigned();
            $table->bigInteger('question_topic_id')->unsigned()->nullable();
            $table->bigInteger('question_subtopic_id')->unsigned()->nullable();
            $table->string('title');
            $table->text('body');
            $table->integer('points');
            $table->timestamps();

            $table->foreign('question_type_id')->references('id')->on('question_types')->onDelete('cascade');
            $table->foreign('question_category_id')->references('id')->on('question_categories')->onDelete('cascade');
        });

        Schema::create('question_multiple_choice', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->string('text');
            $table->boolean('is_right_answer');

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::create('question_true_or_false', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->boolean('right_answer');
        
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::create('question_fill_in_the_blanks', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->string('right_answer');
        
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        // Schema::create('examination_instance_part_questions', function (Blueprint $table){
        //     $table->bigIncrements('id');
        //     $table->bigInteger('part_id')->unsigned();
        //     $table->bigInteger('question_id')->unsigned();
            
        //     $table->foreign('part_id')->references('id')->on('examination_instance_parts')->onDelete('cascade'); 
        //     $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('examination_instance_part_questions');
        Schema::drop('question_fill_in_the_blanks');
        Schema::drop('question_true_or_false');
        Schema::drop('question_multiple_choice');
        Schema::drop('questions');
        Schema::drop('question_topics');
        Schema::drop('question_categorys');
        Schema::drop('question_types');
    }
}
