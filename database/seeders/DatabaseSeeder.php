<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ClassroomSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AcademicYearSeeder::class,
            CycleSeeder::class,
            LevelSeeder::class,
            ClassroomSeeder::class,
            StudentSeeder::class
        ]);
    }
}
