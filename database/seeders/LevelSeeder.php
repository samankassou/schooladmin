<?php

namespace Database\Seeders;

use App\Models\Cycle;
use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create([
            'name' => '6e',
            'cycle_id' => Cycle::where('name', '1er Cycle')->first()->id
        ]);
        Level::create([
            'name' => '5e',
            'cycle_id' => Cycle::where('name', '1er Cycle')->first()->id
        ]);
        Level::create([
            'name' => '4e',
            'cycle_id' => Cycle::where('name', '1er Cycle')->first()->id
        ]);
        Level::create([
            'name' => '3e',
            'cycle_id' => Cycle::where('name', '1er Cycle')->first()->id
        ]);
        Level::create([
            'name' => '2nde',
            'cycle_id' => Cycle::where('name', '2nd Cycle')->first()->id
        ]);
        Level::create([
            'name' => '1ère',
            'cycle_id' => Cycle::where('name', '2nd Cycle')->first()->id
        ]);
        Level::create([
            'name' => 'Tle',
            'cycle_id' => Cycle::where('name', '2nd Cycle')->first()->id
        ]);
    }
}
