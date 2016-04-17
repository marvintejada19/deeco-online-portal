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
        Schema::create('subject_requirements', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->dateTime('published_at');
            $table->dateTime('event_start');
            $table->dateTime('event_end');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });

        Schema::create('subject_requirement_files', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_requirement_id')->unsigned();
            $table->bigInteger('file_id')->unsigned();
            
            $table->foreign('subject_requirement_id')->references('id')->on('subject_requirements')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subject_requirement_files');
        Schema::drop('subject_requirements');
    }
}
