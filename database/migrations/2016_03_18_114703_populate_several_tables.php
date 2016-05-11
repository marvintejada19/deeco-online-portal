<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateSeveralTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* 'users' table
         */
            DB::table('users')->insert(array(
                'username'   => 'admin', 
                'password'   => bcrypt('password'),
                'role_id'    => '1',
            ));
            DB::table('users')->insert(array(
                'username'   => 'school', 
                'password'   => bcrypt('password'),
                'role_id'    => '2',
            ));
            DB::table('users')->insert(array(
                'username'   => 'john.doe', 
                'password'   => bcrypt('password'),
                'role_id'    => '3',
            ));
            DB::table('users')->insert(array(
                'username'   => 'faculty2', 
                'password'   => bcrypt('password'),
                'role_id'    => '3',
            ));
            DB::table('users')->insert(array(
                'username'   => 'student', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'student2', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'student3', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));

        /* 'sections' table
         */
            DB::table('sections')->insert(array(
                'grade_level' => '4',
                'section_name' => 'loyalty',
            ));
            DB::table('sections')->insert(array(
                'grade_level' => '5',
                'section_name' => 'obedience',
            ));
            DB::table('sections')->insert(array(
                'grade_level' => '6',
                'section_name' => 'wisdom',
            ));

        /* 'subjects' table
         */
            DB::table('subjects')->insert(array(
                'user_id' => '3',
                'section_id' => '1',
                'sy' => '2015-2016',
                'is_adviser' => '1',
                'subject_title' => 'grade 4 mathematics',
                'units' => '3',
            ));
            DB::table('subjects')->insert(array(
                'user_id' => '3',
                'section_id' => '1',
                'sy' => '2015-2016',
                'is_adviser' => '0',
                'subject_title' => 'grade 4 science',
                'units' => '3',
            ));
            DB::table('subjects')->insert(array(
                'user_id' => '3',
                'section_id' => '2',
                'sy' => '2015-2016',
                'is_adviser' => '0',
                'subject_title' => 'grade 4 physics',
                'units' => '3',
            ));

        /* 'subject_class_enrollments' table
         */
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '1',
                'user_id' => '5',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '1',
                'user_id' => '6',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '1',
                'user_id' => '7',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '2',
                'user_id' => '5',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '2',
                'user_id' => '6',
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
