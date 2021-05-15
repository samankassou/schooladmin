<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'level_id', 'academic_year_id', 'head_teacher'];

    public $timestamps = false;

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'school_path', 'classroom_id', 'student_id');
    }

    public function headTeacher()
    {
        return $this->hasOne(User::class, 'id', 'head_teacher');
    }
}
