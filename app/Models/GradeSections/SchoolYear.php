<?php

namespace App\Models\GradeSections;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $fillable = ['name', 'active'];
	protected $table = 'school_years';
    public $timestamps = false; 
}
