<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classroom::create([
            'name' => '6e A',
            'level_id' => Level::where('name', '6e')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '6e B',
            'level_id' => Level::where('name', '6e')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '5e A',
            'level_id' => Level::where('name', '5e')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '5e B',
            'level_id' => Level::where('name', '5e')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '4e A',
            'level_id' => Level::where('name', '4e')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '4e B',
            'level_id' => Level::where('name', '4e')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '3e A Allemand',
            'level_id' => Level::where('name', '3e')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '3e A Espagnole',
            'level_id' => Level::where('name', '3e')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '2nde A4 Allemand',
            'level_id' => Level::where('name', '2nde')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '2nde A4 Espagnole',
            'level_id' => Level::where('name', '2nde')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '2nde C',
            'level_id' => Level::where('name', '2nde')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '1ère A4 Allemand',
            'level_id' => Level::where('name', '1ère')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '1ère A4 Espagnole',
            'level_id' => Level::where('name', '1ère')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '1ère C',
            'level_id' => Level::where('name', '1ère')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => '1ère D',
            'level_id' => Level::where('name', '1ère')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => 'Tle A4 Espagnole',
            'level_id' => Level::where('name', 'Tle')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => 'Tle A4 Allemand',
            'level_id' => Level::where('name', 'Tle')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => 'Tle C',
            'level_id' => Level::where('name', 'Tle')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
        Classroom::create([
            'name' => 'Tle D',
            'level_id' => Level::where('name', 'Tle')->first()->id,
            'academic_year_id' => AcademicYear::where('name', '2020/2021')->first()->id,
        ]);
    }
}
