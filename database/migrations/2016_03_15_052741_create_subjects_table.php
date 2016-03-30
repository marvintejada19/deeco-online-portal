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
            $table->boolean('is_adviser');
            $table->string('subject_title');
            $table->integer('units');

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

        Schema::create('subject_categorys', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned();
            $table->string('name');
            $table->decimal('weight', 10, 5);
            
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade'); 
        });

        Schema::create('subject_category_instances', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_category_id')->unsigned();
            $table->string('name');
            $table->date('date_added');
            $table->integer('total_points');
            
            $table->foreign('subject_category_id')->references('id')->on('subject_categorys')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subject_category_instances');
        Schema::drop('subject_class_enrollments');
        Schema::drop('subject_categorys');
        Schema::drop('subjects');
        Schema::drop('sections');
    }
}
