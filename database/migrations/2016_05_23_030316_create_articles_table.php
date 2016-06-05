<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('grade_section_subject_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->dateTime('publish_on');
            $table->softDeletes();
            $table->timestamps();        

            $table->foreign('grade_section_subject_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('announcements');
    }
}
