<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	protected $fillable = [
		'grade_level',
		'section_name',
	];

	public $timestamps = false;

    public function subjects(){
    	return $this->hasMany('App\Models\Subjects\Subject');
    }

    public function getName(){
    	$name = $this->grade_level . ' - ' . $this->section_name;
    	return $name;
    }
}
