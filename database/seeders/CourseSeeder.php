<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::Create([
            'name' => 'Français',
            'academic_year_id' => AcademicYear::current()->id
        ]);

        Course::Create([
            'name' => 'Anglais',
            'academic_year_id' => AcademicYear::current()->id
        ]);

        Course::Create([
            'name' => 'Informatique',
            'academic_year_id' => AcademicYear::current()->id
        ]);

        Course::Create([
            'name' => 'Mathématiques',
            'academic_year_id' => AcademicYear::current()->id
        ]);
    }
}
