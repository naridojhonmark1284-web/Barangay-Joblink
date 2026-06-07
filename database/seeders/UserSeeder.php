<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    // Create 5 Job Seekers
    for ($i = 1; $i <= 5; $i++) {
        \App\Models\User::create([
            'name' => "Job Seeker $i",
            'email' => "seeker$i@joblink.test",
            'password' => bcrypt('password123'), 
            'role' => 'seeker', // <--- CHANGE THIS to your column name/value
        ]);
    }

    // Create 5 Employers
    for ($i = 1; $i <= 5; $i++) {
        \App\Models\User::create([
            'name' => "Employer Company $i",
            'email' => "employer$i@joblink.test",
            'password' => bcrypt('password123'),
            'role' => 'employer', // <--- CHANGE THIS to your column name/value
        ]);
    }
}
}
