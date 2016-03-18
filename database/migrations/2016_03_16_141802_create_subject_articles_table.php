<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_articles', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_id')->unsigned();
            $table->string('message');
            $table->date('published_at');

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });

        Schema::create('subject_article_files', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('subject_article_id')->unsigned();
            $table->string('file_name');

            $table->foreign('subject_article_id')->references('id')->on('subject_articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subject_articles');
        Schema::drop('subject_article_files');
    }
}
