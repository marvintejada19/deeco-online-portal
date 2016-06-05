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
            $table->bigIncrements('id');
            $table->string('title');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->bigInteger('role_id')->unsigned();
            $table->timestamp('last_login');
            $table->boolean('active')->default('1');
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('idNumber')->unique();
            $table->string('lrnNumber');
            $table->boolean('gender');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('faculty', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('idNumber')->unique();
            $table->boolean('gender');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('school_management', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('idNumber')->unique();
            $table->boolean('gender');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('system_administrator', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('idNumber')->unique();
            $table->boolean('gender');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


        DB::table('roles')->insert(['title' => 'System Administrator']);
        DB::table('roles')->insert(['title' => 'School Management']);
        DB::table('roles')->insert(['title' => 'Faculty']);
        DB::table('roles')->insert(['title' => 'Student']);  

        DB::table('users')->insert([
            'username'   => 'admin',        'password' => bcrypt('password'), 'role_id' => '1', 'active' => '1']);      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('system_administrator');
        Schema::drop('school_management');
        Schema::drop('faculty');
        Schema::drop('students');
        Schema::drop('users');
        Schema::drop('roles');
    }
}
