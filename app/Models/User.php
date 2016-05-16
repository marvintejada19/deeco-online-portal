<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'role_id', 'last_login'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRole(){
        return DB::table('roles')->where('id', $this->role_id)->first()->title;
    }

    public function articles(){
        return $this->hasMany('App\Models\Article');
    }

    public function subjects(){
        return $this->hasMany('App\Models\Subjects\Subject');
    }

    public function examinations(){
        return $this->hasMany('App\Models\Subjects\SubjectExaminationInstance');
    }

    public function classes(){
        return $this->belongsToMany('App\Models\Subjects\Subject', 'subject_class_enrollments');
    }

    public function subjectRequirementInstance(){
        return $this->hasMany('App\Models\Subjects\SubjectRequirementInstance');
    }

    public function files(){
        return $this->hasMany('App\Models\File');
    }

}
