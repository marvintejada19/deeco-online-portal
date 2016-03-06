<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password', 60);
            $table->integer('role_id')->unsigned();
            $table->boolean('active');
            $table->boolean('firstLogin');
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        DB::table('roles')->insert(array('title' => 'System Administrator'));
        DB::table('roles')->insert(array('title' => 'School Management'));
        DB::table('roles')->insert(array('title' => 'Faculty'));
        DB::table('roles')->insert(array('title' => 'Student'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('roles');
    }
}
