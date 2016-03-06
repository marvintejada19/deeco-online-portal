<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_faculty_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->date('birthdate');
            $table->string('place_of_birth');
            $table->string('address');
            $table->string('landline_no');
            $table->string('cellphone_no');
            $table->string('gender');
            $table->string('religion');
            $table->string('citizenship');
            $table->string('email_address');
            $table->string('course');
            $table->string('school_graduated');
            $table->string('year_graduated');
            $table->string('let_score');
            $table->date('date_late_was_taken');
            $table->date('date_of_initial_appointment');
            $table->string('salary_grade_level');
            $table->string('initial_salary');
            $table->string('post_graduate')->nullable();
            $table->text('other_info')->nullable();
            $table->text('family_info')->nullable();
            $table->string('emergency_contact_person');
            $table->string('emergency_contact_no');
            $table->timestamps(); 

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('user_student_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->date('birthdate');
            $table->string('place_of_birth');
            $table->string('address');
            $table->string('landline_no');
            $table->string('gender');
            $table->string('religion');
            $table->string('citizenship');
            $table->string('email_address');
            $table->string('school_last_attended')->nullable();
            $table->string('school_address')->nullable();
            $table->date('date_graduated')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_home_address')->nullable();
            $table->string('father_home_landline_no')->nullable();
            $table->string('father_cellphone_no')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_business_address')->nullable();
            $table->string('father_business_landline_no')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_home_address')->nullable();
            $table->string('mother_home_landline_no')->nullable();
            $table->string('mother_cellphone_no')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_business_address')->nullable();
            $table->string('mother_business_landline_no')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_home_address')->nullable();
            $table->string('guardian_home_landline_no')->nullable();
            $table->string('guardian_cellphone_no')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->string('guardian_business_address')->nullable();
            $table->string('guardian_business_landline_no')->nullable();
            $table->string('emergency_contact_person');
            $table->string('emergency_contact_no');
            $table->string('initial_grade_level');
            $table->string('evaluator_assessment');
            /*
                TO BE CONTINUED

            */
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_faculty_details');
        Schema::drop('user_student_details');
    }
}
