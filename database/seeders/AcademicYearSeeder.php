<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcademicYear::create([
            'name' => '2020/2021',
            'start_date' => Carbon::createFromDate(2020, 9, 5),
            'end_date' => Carbon::createFromDate(2021, 6, 5)
        ]);
    }
}
