<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    protected $fillable = [
        'username', 
        'password', 
        'role_id', 
        'last_login',
        'active', 
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRole(){
        return DB::table('roles')->where('id', $this->role_id)->first()->title;
    }

    public function getInfo(){
        switch ($this->getRole()){
            case 'System Administrator':
                $table = 'system_administrator';
                break;
            case 'School Management':
                $table = 'school_management';
                break;
            case 'Faculty':
                $table = 'faculty';                
                break;
            case 'Student':
                $table = 'students';
                break;
        }
        return DB::table($table)->where('user_id', $this->id)->first();
    }

    public function getFullName(){
        $info = $this->getInfo();
        return ($info->lastname . ', ' . $info->firstname);
    }

    public function gradeSections(){
        return $this->belongsToMany('App\Models\GradeSections\GradeSection', 'enrollments', 'user_id', 'grade_section_id');
    }

    public function gradeSectionSubjects(){
        return $this->belongsToMany('App\Models\GradeSectionSubjects\GradeSectionSubject', 'faculty_loadings');
    }

//-----------------------------------------------------------------------------------
    public function articles(){
        return $this->hasMany('App\Models\Article');
    }

    public function examinations(){
        return $this->hasMany('App\Models\Subjects\SubjectExaminationInstance');
    }

    public function subjectRequirementInstance(){
        return $this->hasMany('App\Models\Subjects\SubjectRequirementInstance');
    }

    public function files(){
        return $this->hasMany('App\Models\File');
    }

}
