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
        /* 'grade-levels' table
         */
        DB::table('grade_levels')->insert(['name' => 'Nursery']);
        DB::table('grade_levels')->insert(['name' => 'Kinder 1']);
        DB::table('grade_levels')->insert(['name' => 'Kinder 2']);
        DB::table('grade_levels')->insert(['name' => 'Grade 1']);
        DB::table('grade_levels')->insert(['name' => 'Grade 2']);
        DB::table('grade_levels')->insert(['name' => 'Grade 3']);
        DB::table('grade_levels')->insert(['name' => 'Grade 4']);
        DB::table('grade_levels')->insert(['name' => 'Grade 5']);
        DB::table('grade_levels')->insert(['name' => 'Grade 6']);
        DB::table('grade_levels')->insert(['name' => 'Grade 7']);
        DB::table('grade_levels')->insert(['name' => 'Grade 8']);
        DB::table('grade_levels')->insert(['name' => 'Grade 9']);
        DB::table('grade_levels')->insert(['name' => 'Grade 10']);
        DB::table('grade_levels')->insert(['name' => 'Grade 11']);
        DB::table('grade_levels')->insert(['name' => 'Grade 12']);

        /* 'grade_section_names' table
         */
        DB::table('grade_section_names')->insert(['grade_level_id' => '1', 'name' => 'Love']); //1
        DB::table('grade_section_names')->insert(['grade_level_id' => '1', 'name' => 'Peace']); //2
        DB::table('grade_section_names')->insert(['grade_level_id' => '2', 'name' => 'Faith']); //3
        DB::table('grade_section_names')->insert(['grade_level_id' => '2', 'name' => 'Hope']); //4
        DB::table('grade_section_names')->insert(['grade_level_id' => '3', 'name' => 'Honor']); //5
        DB::table('grade_section_names')->insert(['grade_level_id' => '3', 'name' => 'Truth']); //6
        DB::table('grade_section_names')->insert(['grade_level_id' => '4', 'name' => 'Unity']); //7
        DB::table('grade_section_names')->insert(['grade_level_id' => '4', 'name' => 'Honesty']); //8
        DB::table('grade_section_names')->insert(['grade_level_id' => '5', 'name' => 'Courage']); //9
        DB::table('grade_section_names')->insert(['grade_level_id' => '5', 'name' => 'Purity']); //10
        DB::table('grade_section_names')->insert(['grade_level_id' => '6', 'name' => 'Sincerity']); //11
        DB::table('grade_section_names')->insert(['grade_level_id' => '6', 'name' => 'Creative']); //12
        DB::table('grade_section_names')->insert(['grade_level_id' => '7', 'name' => 'Bravery']); //13
        DB::table('grade_section_names')->insert(['grade_level_id' => '7', 'name' => 'Respect']); //14
        DB::table('grade_section_names')->insert(['grade_level_id' => '8', 'name' => 'Discipline']); //15
        DB::table('grade_section_names')->insert(['grade_level_id' => '8', 'name' => 'Obedience']); //16
        DB::table('grade_section_names')->insert(['grade_level_id' => '9', 'name' => 'Loyalty']); //17
        DB::table('grade_section_names')->insert(['grade_level_id' => '9', 'name' => 'Dignity']); //18
        DB::table('grade_section_names')->insert(['grade_level_id' => '10', 'name' => 'Integrity']); //19
        DB::table('grade_section_names')->insert(['grade_level_id' => '10', 'name' => 'Patience']); //20
        DB::table('grade_section_names')->insert(['grade_level_id' => '11', 'name' => 'Temperance']); //21
        DB::table('grade_section_names')->insert(['grade_level_id' => '11', 'name' => 'Simplicity']); //22
        DB::table('grade_section_names')->insert(['grade_level_id' => '12', 'name' => 'Humility']); //23
        DB::table('grade_section_names')->insert(['grade_level_id' => '12', 'name' => 'Generosity']); //24
        DB::table('grade_section_names')->insert(['grade_level_id' => '13', 'name' => 'Wisdom']); //25
        DB::table('grade_section_names')->insert(['grade_level_id' => '13', 'name' => 'Perseverance']); //26

        /* 'school_years' table
         */
        DB::table('school_years')->insert(['name' => '2015-2016', 'active' => '1']);

        /* 'grade_sections' table
         */
        DB::table('grade_sections')->insert(['grade_section_name_id' => '1', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '2', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '3', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '4', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '5', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '6', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '7', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '8', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '9', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '10', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '11', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '12', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '13', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '14', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '15', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '16', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '17', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '18', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '19', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '20', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '21', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '22', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '23', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '24', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '25', 'school_year_id' => '1']);
        DB::table('grade_sections')->insert(['grade_section_name_id' => '26', 'school_year_id' => '1']);
        

        /* 'subjects' table
         */
        DB::table('subjects')->insert(['name' => 'Grade 1 Science']); //1
        DB::table('subjects')->insert(['name' => 'Grade 2 Science']); //2
        DB::table('subjects')->insert(['name' => 'Grade 3 Science']); //3
        DB::table('subjects')->insert(['name' => 'Grade 4 Science']); //4
        DB::table('subjects')->insert(['name' => 'Grade 5 Science']); //5
        DB::table('subjects')->insert(['name' => 'Grade 6 Science']); //6
        DB::table('subjects')->insert(['name' => 'Grade 7 Science']); //7
        DB::table('subjects')->insert(['name' => 'Grade 8 Science']); //8
        DB::table('subjects')->insert(['name' => 'Grade 9 Science']); //9
        DB::table('subjects')->insert(['name' => 'Grade 10 Science']); //10
        DB::table('subjects')->insert(['name' => 'Grade 11 Science']); //11
        DB::table('subjects')->insert(['name' => 'Grade 12 Science']); //12
        DB::table('subjects')->insert(['name' => 'Grade 1 Mathematics']); //13
        DB::table('subjects')->insert(['name' => 'Grade 2 Mathematics']); //14
        DB::table('subjects')->insert(['name' => 'Grade 3 Mathematics']); //15
        DB::table('subjects')->insert(['name' => 'Grade 4 Mathematics']); //16
        DB::table('subjects')->insert(['name' => 'Grade 5 Mathematics']); //17
        DB::table('subjects')->insert(['name' => 'Grade 6 Mathematics']); //18
        DB::table('subjects')->insert(['name' => 'Grade 7 Mathematics']); //19
        DB::table('subjects')->insert(['name' => 'Grade 8 Mathematics']); //20
        DB::table('subjects')->insert(['name' => 'Grade 9 Mathematics']); //21
        DB::table('subjects')->insert(['name' => 'Grade 10 Mathematics']); //22
        DB::table('subjects')->insert(['name' => 'Grade 11 Mathematics']); //23
        DB::table('subjects')->insert(['name' => 'Grade 12 Mathematics']); //24
        DB::table('subjects')->insert(['name' => 'Grade 1 Araling Panlipunan']); //25
        DB::table('subjects')->insert(['name' => 'Grade 2 Araling Panlipunan']); //26
        DB::table('subjects')->insert(['name' => 'Grade 3 Araling Panlipunan']); //27
        DB::table('subjects')->insert(['name' => 'Grade 4 Araling Panlipunan']); //28
        DB::table('subjects')->insert(['name' => 'Grade 5 Araling Panlipunan']); //29
        DB::table('subjects')->insert(['name' => 'Grade 6 Araling Panlipunan']); //30
        DB::table('subjects')->insert(['name' => 'Grade 7 Araling Panlipunan']); //31
        DB::table('subjects')->insert(['name' => 'Grade 8 Araling Panlipunan']); //32
        DB::table('subjects')->insert(['name' => 'Grade 9 Araling Panlipunan']); //33
        DB::table('subjects')->insert(['name' => 'Grade 10 Araling Panlipunan']); //34
        DB::table('subjects')->insert(['name' => 'Grade 11 Araling Panlipunan']); //35
        DB::table('subjects')->insert(['name' => 'Grade 12 Araling Panlipunan']); //36
        DB::table('subjects')->insert(['name' => 'Grade 1 History']); //37
        DB::table('subjects')->insert(['name' => 'Grade 2 History']); //38
        DB::table('subjects')->insert(['name' => 'Grade 3 History']); //39
        DB::table('subjects')->insert(['name' => 'Grade 4 History']); //40
        DB::table('subjects')->insert(['name' => 'Grade 5 History']); //41
        DB::table('subjects')->insert(['name' => 'Grade 6 History']); //42
        DB::table('subjects')->insert(['name' => 'Grade 7 History']); //43
        DB::table('subjects')->insert(['name' => 'Grade 8 History']); //44
        DB::table('subjects')->insert(['name' => 'Grade 9 History']); //45
        DB::table('subjects')->insert(['name' => 'Grade 10 History']); //46
        DB::table('subjects')->insert(['name' => 'Grade 11 History']); //47
        DB::table('subjects')->insert(['name' => 'Grade 12 History']); //48
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
