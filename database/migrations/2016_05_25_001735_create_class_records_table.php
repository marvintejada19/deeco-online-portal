<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_class_records', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('grade_section_subject_id')->unsigned();
            $table->bigInteger('deployment_id')->unsigned();
            $table->integer('quarter');
        
            $table->foreign('grade_section_subject_id')->references('id')->on('grade_section_subjects')->onDelete('cascade'); 
            $table->foreign('deployment_id')->references('id')->on('deployments')->onDelete('cascade');
        });

        Schema::create('subject_class_record_instances', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_class_record_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('score');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subject_class_record_id')->references('id')->on('subject_class_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subject_class_record_instances');
        Schema::drop('subject_class_records');
    }
}
