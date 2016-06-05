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
            $table->string('name');
        });

        Schema::create('question_categories', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('question_topics', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_category_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('question_category_id')->references('id')->on('question_categories')->onDelete('cascade');
        });

        Schema::create('question_subtopics', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_topic_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('question_topic_id')->references('id')->on('question_topics')->onDelete('cascade');
        });

        Schema::create('questions', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_type_id')->unsigned();
            $table->bigInteger('question_subtopic_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->bigInteger('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('question_type_id')->references('id')->on('question_types')->onDelete('cascade');
            $table->foreign('question_subtopic_id')->references('id')->on('question_subtopics')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('question_multiple_choice', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->text('text');
            $table->boolean('is_right_answer');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::create('question_true_or_false', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->boolean('right_answer');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::create('question_fill_in_the_blanks', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->string('right_answer');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::create('question_match_columns_choices', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->text('text');
            
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::create('question_match_columns_items', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('columns_choice_id')->unsigned();
            $table->text('text');

            $table->foreign('columns_choice_id')->references('id')->on('question_match_columns_choices')->onDelete('cascade');
        });

        Schema::create('question_select_from_the_wordbox_choices', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->text('text');
            
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::create('question_select_from_the_wordbox_items', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('wordbox_choice_id')->unsigned();
            $table->text('text');

            $table->foreign('wordbox_choice_id')->references('id')->on('question_select_from_the_wordbox_choices')->onDelete('cascade');
        });

        DB::table('question_categories')->insert(array(
            'name' => 'Default Category', 
        ));
        DB::table('question_topics')->insert(array(
            'name' => 'Default Topic', 
            'question_category_id' => '1',
        ));
        DB::table('question_subtopics')->insert(array(
            'name' => 'Default Subtopic', 
            'question_topic_id' => '1',
        ));

        DB::table('question_types')->insert(array(
            'name' => 'Multiple Choice', 
        ));
        DB::table('question_types')->insert(array(
            'name' => 'True or False', 
        ));
        DB::table('question_types')->insert(array(
            'name' => 'Fill in the Blanks', 
        ));
        DB::table('question_types')->insert(array(
            'name' => 'Match Column A with Column B', 
        ));
        DB::table('question_types')->insert(array(
            'name' => 'Select from the Wordbox', 
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('question_select_from_the_wordbox_items');
        Schema::drop('question_select_from_the_wordbox_choices');
        Schema::drop('question_match_columns_items');
        Schema::drop('question_match_columns_choices');
        Schema::drop('question_fill_in_the_blanks');
        Schema::drop('question_true_or_false');
        Schema::drop('question_multiple_choice');
        Schema::drop('questions');
        Schema::drop('question_subtopics');
        Schema::drop('question_topics');
        Schema::drop('question_categories');
        Schema::drop('question_types');
    }
}
