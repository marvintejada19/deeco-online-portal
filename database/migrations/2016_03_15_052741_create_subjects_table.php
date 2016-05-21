<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('grade_level');
            $table->string('section_name');
        });

        Schema::create('subjects', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('section_id')->unsigned();
            $table->string('sy');
            $table->string('subject_title');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });

        Schema::create('subject_class_enrollments', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('subject_class_record', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('subcategory');
            $table->string('description');
            $table->date('date_deployed');
            $table->integer('total_points');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subject_class_record');
        Schema::drop('subject_class_enrollments');
        Schema::drop('subjects');
        Schema::drop('sections');
    }
}
