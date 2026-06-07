<?php

namespace App\Http\Controllers;

use App\Models\Application as JobApplication;
use App\Models\ApplicationLog;
use App\Models\HiringLog;
use App\Models\JobCategory;
use App\Models\JobPost;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployerController extends Controller
{
    private function currentEmployer()
    {
        if (auth()->user()->role !== 'employer') {
            abort(403);
        }

        $employer = auth()->user()->employer;

        if (!$employer) {
            abort(403, 'Employer profile not found.');
        }

        return $employer;
    }

    public function dashboard()
{
    $employer = $this->currentEmployer();

    $jobs = JobPost::with(['jobCategory', 'skills'])
        ->withCount([
            'applications',
            'applications as pending_applications_count' => function ($query) {
                $query->where('status', 'pending');
            },
            'applications as shortlisted_applications_count' => function ($query) {
                $query->where('status', 'shortlisted');
            },
            'applications as hired_applications_count' => function ($query) {
                $query->where('status', 'hired');
            },
        ])
        ->where('employer_id', $employer->id)
        ->latest()
        ->get();

    $summary = [
        'total_jobs' => $jobs->count(),
        'open_jobs' => $jobs->where('status', 'open')->count(),
        'filled_jobs' => $jobs->where('status', 'filled')->count(),
        'total_applications' => $jobs->sum('applications_count'),
        'total_hired' => $jobs->sum('hired_applications_count'),
    ];

    return view('employer.dashboard', compact('employer', 'jobs', 'summary'));
}

    public function create()
    {
        $this->currentEmployer();

        $categories = JobCategory::orderBy('category_name')->get();
        $skills = Skill::orderBy('skill_name')->get();

        return view('employer.create-job', compact('categories', 'skills'));
    }

    public function store(Request $request)
    {
        $employer = $this->currentEmployer();

        $validated = $request->validate([
            'job_category_id' => 'nullable|exists:job_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'daily_wage' => 'required|numeric|min:0',
            'vacancies' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'skill_ids' => 'nullable|array',
            'skill_ids.*' => 'exists:skills,id',
        ]);

        $job = JobPost::create([
            'employer_id' => $employer->id,
            'job_category_id' => $validated['job_category_id'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'daily_wage' => $validated['daily_wage'],
            'vacancies' => $validated['vacancies'],
            'location' => $validated['location'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'status' => 'open',
        ]);

        if (!empty($validated['skill_ids'])) {
            $job->skills()->sync($validated['skill_ids']);
        }

        return redirect()->route('employer.dashboard')
            ->with('success', 'Job post created successfully.');
    }

public function applications(JobPost $jobPost)
{
    $employer = $this->currentEmployer();

    if ($jobPost->employer_id !== $employer->id) {
        abort(403);
    }

    $applications = $jobPost->applications()
        ->with([
            'jobSeeker.user',
            'jobSeeker.barangayZone',
            'jobSeeker.skills',
            'logs.changedBy',
            'hiringLog',
        ])
        ->latest()
        ->get();

    $summary = [
        'total' => $applications->count(),
        'pending' => $applications->where('status', 'pending')->count(),
        'shortlisted' => $applications->where('status', 'shortlisted')->count(),
        'hired' => $applications->where('status', 'hired')->count(),
        'rejected' => $applications->where('status', 'rejected')->count(),
    ];

    return view('employer.applications', compact('jobPost', 'applications', 'summary'));
}

    public function updateStatus(Request $request, JobApplication $application)
    {
        $employer = $this->currentEmployer();

        $application->load('jobPost');

        if ($application->jobPost->employer_id !== $employer->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'shortlisted', 'hired', 'rejected'])],
            'remarks' => 'nullable|string|max:500',
            'actual_wages_earned' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($application, $validated) {
            $oldStatus = $application->status;
            $newStatus = $validated['status'];

            $application->update([
                'status' => $newStatus,
            ]);

            ApplicationLog::create([
                'application_id' => $application->id,
                'changed_by' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            if ($newStatus === 'hired') {
                HiringLog::updateOrCreate(
                    ['application_id' => $application->id],
                    [
                        'hiring_date' => now()->toDateString(),
                        'actual_wages_earned' => $validated['actual_wages_earned'] ?? $application->jobPost->daily_wage,
                        'is_completed' => false,
                    ]
                );
            } else {
                $application->hiringLog()->delete();
            }

            $hiredCount = JobApplication::where('job_post_id', $application->job_post_id)
                ->where('status', 'hired')
                ->count();

            if ($hiredCount >= $application->jobPost->vacancies) {
                $application->jobPost->update(['status' => 'filled']);
            } else {
                if ($application->jobPost->status === 'filled') {
                    $application->jobPost->update(['status' => 'open']);
                }
            }
        });

        return back()->with('success', 'Application status updated successfully.');
    }
}