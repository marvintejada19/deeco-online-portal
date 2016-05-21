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
                'username'   => 'peter.magboo', 
                'password'   => bcrypt('password'),
                'role_id'    => '3',
            ));
            DB::table('users')->insert(array(
                'username'   => 'shiela.magboo', 
                'password'   => bcrypt('password'),
                'role_id'    => '3',
            ));
            DB::table('users')->insert(array(
                'username'   => 'perl.gasmen', 
                'password'   => bcrypt('password'),
                'role_id'    => '3',
            ));
            DB::table('users')->insert(array(
                'username'   => 'avegail.carpio', 
                'password'   => bcrypt('password'),
                'role_id'    => '3',
            ));
            DB::table('users')->insert(array(
                'username'   => 'richard.chua', 
                'password'   => bcrypt('password'),
                'role_id'    => '3',
            ));
            DB::table('users')->insert(array(
                'username'   => 'marvin.tejada', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'larisse.almiranez', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'gionelle.tribiana', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'sheila.jornadal', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'kriselle.silvestre', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'christine.ocana', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'lei.dadivo', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'marx.molina', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'dwight.pacursa', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'kat.mayuga', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'carl.viernes', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'milytoni.ebo', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));
            DB::table('users')->insert(array(
                'username'   => 'alex.delacruz', 
                'password'   => bcrypt('password'),
                'role_id'    => '4',
            ));

        /* 'sections' table
         */
            DB::table('sections')->insert(array(
                'grade_level' => '4',
                'section_name' => 'Loyalty',
            ));
            DB::table('sections')->insert(array(
                'grade_level' => '5',
                'section_name' => 'Obedience',
            ));
            DB::table('sections')->insert(array(
                'grade_level' => '6',
                'section_name' => 'Wisdom',
            ));
            DB::table('sections')->insert(array(
                'grade_level' => '4',
                'section_name' => 'Deliverance',
            ));
            DB::table('sections')->insert(array(
                'grade_level' => '6',
                'section_name' => 'Courageous',
            ));
            DB::table('sections')->insert(array(
                'grade_level' => '6',
                'section_name' => 'Faithfulness',
            ));
            DB::table('sections')->insert(array(
                'grade_level' => '6',
                'section_name' => 'Purity',
            ));
            DB::table('sections')->insert(array(
                'grade_level' => '5',
                'section_name' => 'Honesty',
            ));

        /* 'subjects' table
         */
            DB::table('subjects')->insert(array(
                'user_id' => '3',
                'section_id' => '1',
                'sy' => '2015-2016',
                'subject_title' => 'Grade 4 mathematics',
            ));
            DB::table('subjects')->insert(array(
                'user_id' => '4',
                'section_id' => '1',
                'sy' => '2015-2016',
                'subject_title' => 'Grade 4 science',
            ));
            DB::table('subjects')->insert(array(
                'user_id' => '3',
                'section_id' => '4',
                'sy' => '2015-2016',
                'subject_title' => 'Grade 4 mathematics',
            ));
            DB::table('subjects')->insert(array(
                'user_id' => '3',
                'section_id' => '2',
                'sy' => '2015-2016',
                'subject_title' => 'Grade 5 mathematics',
            ));
            DB::table('subjects')->insert(array(
                'user_id' => '4',
                'section_id' => '4',
                'sy' => '2015-2016',
                'subject_title' => 'Grade 4 science',
            ));
            DB::table('subjects')->insert(array(
                'user_id' => '5',
                'section_id' => '1',
                'sy' => '2015-2016',
                'subject_title' => 'Grade 4 physics',
            ));

        /* 'subject_class_enrollments' table
         */
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '1',
                'user_id' => '9',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '1',
                'user_id' => '10',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '1',
                'user_id' => '11',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '1',
                'user_id' => '12',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '1',
                'user_id' => '13',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '1',
                'user_id' => '14',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '2',
                'user_id' => '9',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '2',
                'user_id' => '10',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '2',
                'user_id' => '11',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '2',
                'user_id' => '12',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '2',
                'user_id' => '13',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '2',
                'user_id' => '14',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '4',
                'user_id' => '15',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '4',
                'user_id' => '16',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '4',
                'user_id' => '17',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '4',
                'user_id' => '18',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '4',
                'user_id' => '19',
            ));
            DB::table('subject_class_enrollments')->insert(array(
                'subject_id' => '4',
                'user_id' => '20',
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
