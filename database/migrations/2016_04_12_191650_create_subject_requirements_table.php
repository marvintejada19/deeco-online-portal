<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('requirement_files', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('requirement_id')->unsigned();
            $table->bigInteger('file_id')->unsigned();
            
            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::create('subject_requirements', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('requirement_id')->unsigned();
            $table->bigInteger('grade_section_subject_id')->unsigned();
            $table->dateTime('publish_on');
            $table->dateTime('event_start');
            $table->dateTime('event_end');

            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
            $table->foreign('grade_section_subject_id')->references('id')->on('grade_section_subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subject_requirements');
        Schema::drop('requirement_files');
        Schema::drop('requirements');
    }
}
