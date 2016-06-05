<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('question_categories')->insert([
            'id' => '2',
            'name' => 'Science'
        ]);
        //---------------------------------------------------------------------------------------
        DB::table('question_topics')->insert([
            'id' => '2',
            'question_category_id' => '2',
            'name' => 'Default Topic',
        ]);
        DB::table('question_topics')->insert([
            'id' => '3',
            'question_category_id' => '2',
            'name' => 'Biology',
        ]);
        //----------------------------------------------------------------------------------------
        DB::table('question_subtopics')->insert([
            'id' => '2',
            'question_topic_id' => '3',
            'name' => 'Default Subtopic',
        ]);
        DB::table('question_subtopics')->insert([
            'id' => '3',
            'question_topic_id' => '3',
            'name' => 'The cell'
        ]);
        DB::table('question_subtopics')->insert([
            'id' => '4',
            'question_topic_id' => '3',
            'name' => 'Digestive system'
        ]);
        DB::table('question_subtopics')->insert([
            'id' => '5',
            'question_topic_id' => '3',
            'name' => 'Respiratory system'
        ]);
        DB::table('question_subtopics')->insert([
            'id' => '6',
            'question_topic_id' => '3',
            'name' => 'Animal biology'
        ]);
        DB::table('question_subtopics')->insert([
            'id' => '7',
            'question_topic_id' => '3',
            'name' => 'Parts of the human body'
        ]);
        //----------------------------------------------------------------------------------------
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
