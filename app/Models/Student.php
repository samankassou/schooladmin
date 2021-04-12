<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $dates = ['dob'];

    protected $fillable = [
        'firstname',
        'lastname',
        'dob',
        'place_of_birth',
        'gender',
        'mother_name',
        'father_name'
    ];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'school_path', 'student_id', 'classroom_id');
    }

    public function getCurrentClassroomAttribute()
    {
        return $this->classrooms()->firstWhere('academic_year_id', AcademicYear::current()->id);
    }

    public function getDobAttribute($dob)
    {
        return Carbon::parse($dob)->format('d/m/Y');
    }
}
