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
