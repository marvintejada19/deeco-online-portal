<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_posts', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->date('published_at');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });

        Schema::create('subject_post_files', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_post_id')->unsigned();
            
            $table->foreign('subject_post_id')->references('id')->on('subject_posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subject_post_files');
        Schema::drop('subject_posts');
    }
}
