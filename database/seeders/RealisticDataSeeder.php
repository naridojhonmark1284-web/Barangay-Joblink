<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employer;
use App\Models\JobSeeker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RealisticDataSeeder extends Seeder
{
    public function run()
    {
        // ====================== ADMIN ======================
        User::firstOrCreate(
            ['email' => 'admin@joblink.test'],
            [
                'name'     => 'Atty. Maria Santos',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // ====================== JOB SEEKERS ======================
        $seekerData = [
            ['Juan', 'Miguel Reyes'],
            ['Ana', 'Patricia Cruz'],
            ['Carlos', 'Emmanuel Santos'],
            ['Luzviminda', 'Torres'],
            ['Roberto', 'Dela Cruz'],
            ['Michelle', 'Ann Bautista'],
            ['Daniel', 'Joseph Lim'],
            ['Sophia', 'Marie Garcia'],
            ['Kenneth', 'Ray Morales'],
            ['Angelica', 'Rose Villanueva'],
        ];

        foreach ($seekerData as $index => $name) {
            $email = 'seeker' . ($index + 1) . '@joblink.test';
            
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => $name[0] . ' ' . $name[1],
                    'password' => Hash::make('password'),
                    'role'     => 'seeker',
                ]
            );

            if ($user->wasRecentlyCreated) {
                JobSeeker::create([
                    'user_id'             => $user->id,
                    'barangay_zone_id'    => 1,                    // Change if you have specific zones
                    'first_name'          => $name[0],
                    'last_name'           => $name[1],
                    'contact_number'      => '09' . rand(100000000, 999999999),
                    'address'             => fake()->address(),
                    'education_level'     => fake()->randomElement(['High School', 'Bachelor\'s Degree', 'Vocational', 'Master\'s Degree']),
                    'years_experience'    => rand(0, 10),
                    'preferred_daily_wage' => rand(350, 650),
                    'is_verified'         => 1,
                ]);
            }
        }

        // ====================== EMPLOYERS ======================
        $employerData = [
            ['Barangay Tulip Trading', 'Retail'],
            ['Davao Del Norte Construction', 'Construction'],
            ['Luzon Agri Supply Corp', 'Agriculture'],
            ['Golden Harvest Bakery', 'Food Service'],
            ['North Mindanao Hardware', 'Retail'],
        ];

        foreach ($employerData as $index => $data) {
            $email = 'employer' . ($index + 1) . '@joblink.test';
            
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => $data[0],
                    'password' => Hash::make('password'),
                    'role'     => 'employer',
                ]
            );

            if ($user->wasRecentlyCreated) {
                Employer::create([
                    'user_id'         => $user->id,
                    'business_name'   => $data[0],
                    'business_type'   => $data[1],
                    'contact_person'  => fake()->name(),
                    'contact_number'  => '09' . rand(100000000, 999999999),
                    'business_address'=> fake()->address(),
                    'is_accredited'   => 1,
                ]);
            }
        }

        $this->command->info('✅ Realistic Data Seeded Successfully!');
        $this->command->info('   - 1 Admin, 10 Job Seekers, and 5 Employers created.');
        $this->command->info('   Password for all accounts = "password"');
    }
}