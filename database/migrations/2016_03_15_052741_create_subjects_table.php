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
        Schema::create('school_years', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->boolean('active');
        });

        Schema::create('grade_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('grade_section_names', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('grade_level_id')->unsigned();
            $table->string('name');

            $table->foreign('grade_level_id')->references('id')->on('grade_levels')->onDelete('cascade');
        });

        Schema::create('grade_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('grade_section_name_id')->unsigned();
            $table->bigInteger('school_year_id')->unsigned();

            $table->foreign('grade_section_name_id')->references('id')->on('grade_section_names')->onDelete('cascade');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('grade_section_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('grade_section_id')->references('id')->on('grade_sections')->onDelete('cascade');
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('grade_section_subjects', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('grade_section_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();

            $table->foreign('grade_section_id')->references('id')->on('grade_sections')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });

        Schema::create('faculty_loadings', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('grade_section_subject_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('school_year_id')->unsigned()->nullable();

            $table->foreign('grade_section_subject_id')->references('id')->on('grade_section_subjects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('faculty_loadings');
        Schema::drop('grade_section_subjects');
        Schema::drop('subjects');
        Schema::drop('enrollments');
        Schema::drop('grade_sections');
        Schema::drop('grade_section_names');
        Schema::drop('grade_levels');
        Schema::drop('school_years');
    }
}
