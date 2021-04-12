<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false;
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
        return $this->belongsToMany(Classroom::class, 'school_path', 'classroom_id', 'student_id');
    }
}
