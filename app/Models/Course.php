<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'academic_year_id'];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'course_teacher');
    }
}
