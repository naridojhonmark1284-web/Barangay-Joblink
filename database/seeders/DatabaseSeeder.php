<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\ApplicationLog;
use App\Models\BarangayZone;
use App\Models\Employer;
use App\Models\HiringLog;
use App\Models\JobCategory;
use App\Models\JobPost;
use App\Models\JobSeeker;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo users
        $admin = User::create([
            'name' => 'Barangay Admin',
            'email' => 'admin@joblink.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $employerUser = User::create([
            'name' => 'Pedro Employer',
            'email' => 'employer@joblink.test',
            'password' => Hash::make('password'),
            'role' => 'employer',
        ]);

        $seekerUser = User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'seeker@joblink.test',
            'password' => Hash::make('password'),
            'role' => 'seeker',
        ]);

        $seekerUser2 = User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@joblink.test',
            'password' => Hash::make('password'),
            'role' => 'seeker',
        ]);

        // Barangay zones
        $zone1 = BarangayZone::create(['zone_name' => 'Purok 1']);
        $zone2 = BarangayZone::create(['zone_name' => 'Purok 2']);
        $zone3 = BarangayZone::create(['zone_name' => 'Purok 3']);

        // Job categories
        $construction = JobCategory::create(['category_name' => 'Construction']);
        $foodService = JobCategory::create(['category_name' => 'Food Service']);
        $agriculture = JobCategory::create(['category_name' => 'Agriculture']);
        $domestic = JobCategory::create(['category_name' => 'Domestic Work']);

        // Skills
        $carpentry = Skill::create(['skill_name' => 'Carpentry']);
        $cooking = Skill::create(['skill_name' => 'Cooking']);
        $cleaning = Skill::create(['skill_name' => 'Cleaning']);
        $farming = Skill::create(['skill_name' => 'Farming']);
        $driving = Skill::create(['skill_name' => 'Driving']);

        // Employer profile
        $employer = Employer::create([
            'user_id' => $employerUser->id,
            'business_name' => 'Pedro Construction Services',
            'business_type' => 'Construction',
            'contact_person' => 'Pedro Reyes',
            'contact_number' => '09123456789',
            'business_address' => 'Purok 2, Barangay Sample',
            'is_accredited' => true,
        ]);

        // Job seeker profiles
        $seeker = JobSeeker::create([
            'user_id' => $seekerUser->id,
            'barangay_zone_id' => $zone1->id,
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'contact_number' => '09991234567',
            'address' => 'Purok 1, Barangay Sample',
            'education_level' => 'High School Graduate',
            'years_experience' => 2,
            'preferred_daily_wage' => 500,
            'is_verified' => true,
        ]);

        $seeker2 = JobSeeker::create([
            'user_id' => $seekerUser2->id,
            'barangay_zone_id' => $zone2->id,
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'contact_number' => '09997654321',
            'address' => 'Purok 2, Barangay Sample',
            'education_level' => 'College Level',
            'years_experience' => 1,
            'preferred_daily_wage' => 450,
            'is_verified' => true,
        ]);

        // Attach skills to job seekers
        $seeker->skills()->attach($carpentry->id, ['proficiency_level' => 'intermediate']);
        $seeker->skills()->attach($driving->id, ['proficiency_level' => 'beginner']);

        $seeker2->skills()->attach($cooking->id, ['proficiency_level' => 'intermediate']);
        $seeker2->skills()->attach($cleaning->id, ['proficiency_level' => 'expert']);

        // Job posts
        $job1 = JobPost::create([
            'employer_id' => $employer->id,
            'job_category_id' => $construction->id,
            'title' => 'Construction Helper',
            'description' => 'Assist carpenters and masons in daily construction tasks.',
            'daily_wage' => 500,
            'vacancies' => 2,
            'location' => 'Purok 2',
            'deadline' => now()->addDays(10),
            'status' => 'open',
        ]);

        $job2 = JobPost::create([
            'employer_id' => $employer->id,
            'job_category_id' => $foodService->id,
            'title' => 'Kitchen Assistant',
            'description' => 'Help prepare food, clean kitchen area, and assist cook.',
            'daily_wage' => 450,
            'vacancies' => 1,
            'location' => 'Purok 1',
            'deadline' => now()->addDays(7),
            'status' => 'open',
        ]);

        $job3 = JobPost::create([
            'employer_id' => $employer->id,
            'job_category_id' => $agriculture->id,
            'title' => 'Farm Worker',
            'description' => 'Assist in planting, harvesting, and farm maintenance.',
            'daily_wage' => 400,
            'vacancies' => 3,
            'location' => 'Purok 3',
            'deadline' => now()->addDays(14),
            'status' => 'open',
        ]);

        // Attach required skills to jobs
        $job1->skills()->attach($carpentry->id);
        $job2->skills()->attach($cooking->id);
        $job2->skills()->attach($cleaning->id);
        $job3->skills()->attach($farming->id);

        // One sample hired application for reports
        $application = Application::create([
            'job_post_id' => $job1->id,
            'job_seeker_id' => $seeker->id,
            'status' => 'hired',
            'message' => 'I have experience in construction work.',
            'applied_at' => now(),
        ]);

        ApplicationLog::create([
            'application_id' => $application->id,
            'changed_by' => $employerUser->id,
            'old_status' => 'pending',
            'new_status' => 'hired',
            'remarks' => 'Applicant was hired for construction helper position.',
        ]);

        HiringLog::create([
            'application_id' => $application->id,
            'hiring_date' => now()->toDateString(),
            'completion_date' => null,
            'actual_wages_earned' => 3000,
            'is_completed' => false,
        ]);
    }
}