<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'M. John Doe',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'status' => true
        ]);
        $principal = User::create([
            'name' => 'M. Boussa Benjamin',
            'email' => 'principal@principal.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'status' => true
        ]);
        $teacher1 = User::create([
            'name' => 'Mme Kokea',
            'email' => 'kokea@admin.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'status' => true
        ]);
        $teacher2 = User::create([
            'name' => 'Mme Aissatou',
            'email' => 'teacher@teacher.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'status' => true
        ]);
        $admin->assignRole('Admin');
        $principal->assignRole('Proviseur');
        $teacher1->assignRole('Enseignant');
        $teacher2->assignRole('Enseignant');
    }
}
