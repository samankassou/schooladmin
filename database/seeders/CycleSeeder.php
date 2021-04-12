<?php

namespace Database\Seeders;

use App\Models\Cycle;
use Illuminate\Database\Seeder;

class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cycle::create([
            'name' => '1er Cycle'
        ]);
        Cycle::create([
            'name' => '2nd Cycle'
        ]);
    }
}
