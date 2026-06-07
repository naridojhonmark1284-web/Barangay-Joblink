<?php

namespace App\Http\Controllers;

use App\Models\Application as JobApplication;
use App\Models\ApplicationLog;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
public function index(Request $request)
{
    $query = JobPost::with(['employer', 'jobCategory', 'skills'])
        ->where('status', 'open');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        });
    }

    $jobs = $query->latest()->paginate(10)->withQueryString();

    $appliedJobIds = [];

    if (auth()->user()->role === 'seeker' && auth()->user()->jobSeeker) {
        $appliedJobIds = JobApplication::where('job_seeker_id', auth()->user()->jobSeeker->id)
            ->pluck('job_post_id')
            ->toArray();
    }

    return view('jobs.index', compact('jobs', 'appliedJobIds'));
}

    public function apply(Request $request, JobPost $jobPost)
    {
        if (auth()->user()->role !== 'seeker') {
            return back()->with('error', 'Only job seekers can apply for jobs.');
        }

        $seeker = auth()->user()->jobSeeker;

        if (!$seeker) {
            return back()->with('error', 'Job seeker profile not found.');
        }

        if ($jobPost->status !== 'open') {
            return back()->with('error', 'This job is no longer open.');
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $alreadyApplied = JobApplication::where('job_post_id', $jobPost->id)
            ->where('job_seeker_id', $seeker->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'You already applied for this job.');
        }

        DB::transaction(function () use ($request, $jobPost, $seeker) {
            $application = JobApplication::create([
                'job_post_id' => $jobPost->id,
                'job_seeker_id' => $seeker->id,
                'status' => 'pending',
                'message' => $request->message,
                'applied_at' => now(),
            ]);

            ApplicationLog::create([
                'application_id' => $application->id,
                'changed_by' => auth()->id(),
                'old_status' => null,
                'new_status' => 'pending',
                'remarks' => 'Application submitted by job seeker.',
            ]);
        });

        return back()->with('success', 'Application submitted successfully.');
    }

    public function myApplications()
{
    if (auth()->user()->role !== 'seeker') {
        abort(403);
    }

    $seeker = auth()->user()->jobSeeker;

    if (!$seeker) {
        return back()->with('error', 'Job seeker profile not found.');
    }

    $applications = JobApplication::with([
            'jobPost.employer',
            'jobPost.jobCategory',
            'jobPost.skills',
            'hiringLog'
        ])
        ->where('job_seeker_id', $seeker->id)
        ->latest()
        ->get();

    return view('jobs.my-applications', compact('applications'));
    }
}