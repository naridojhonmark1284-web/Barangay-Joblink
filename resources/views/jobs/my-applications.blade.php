<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    My Applications
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Track your submitted job applications and hiring status.
                </p>
            </div>

            <a href="{{ route('jobs.index') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                Browse Jobs
            </a>
        </div>
    </x-slot>

    @php
        $totalApplications = $applications->count();
        $pendingCount = $applications->where('status', 'pending')->count();
        $shortlistedCount = $applications->where('status', 'shortlisted')->count();
        $hiredCount = $applications->where('status', 'hired')->count();
        $rejectedCount = $applications->where('status', 'rejected')->count();
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Summary Hero -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-700 via-emerald-800 to-blue-900 text-white shadow-xl mb-6">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-20 -left-20 h-72 w-72 rounded-full bg-white"></div>
                    <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-white"></div>
                </div>

                <div class="relative z-10 p-8 md:p-10">
                    <p class="text-sm uppercase tracking-[0.3em] text-emerald-200 font-semibold mb-3">
                        Application Tracker
                    </p>

                    <h1 class="text-3xl md:text-4xl font-black leading-tight">
                        Monitor your job application progress.
                    </h1>

                    <p class="mt-4 text-emerald-50 leading-relaxed max-w-3xl">
                        This page shows all jobs you have applied for, including current status,
                        employer details, wage information, and application results.
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-8">
                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-emerald-100">Total</p>
                            <p class="text-3xl font-black">{{ $totalApplications }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-emerald-100">Pending</p>
                            <p class="text-3xl font-black">{{ $pendingCount }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-emerald-100">Shortlisted</p>
                            <p class="text-3xl font-black">{{ $shortlistedCount }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-emerald-100">Hired</p>
                            <p class="text-3xl font-black">{{ $hiredCount }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-emerald-100">Rejected</p>
                            <p class="text-3xl font-black">{{ $rejectedCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications List -->
            <div class="space-y-5">
                @forelse ($applications as $application)
                    @php
                        $status = $application->status;

                        $statusClass = [
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                            'shortlisted' => 'bg-blue-50 text-blue-700 border-blue-100',
                            'hired' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            'rejected' => 'bg-red-50 text-red-700 border-red-100',
                        ][$status] ?? 'bg-slate-50 text-slate-700 border-slate-100';

                        $progressMap = [
                            'pending' => 33,
                            'shortlisted' => 66,
                            'hired' => 100,
                            'rejected' => 100,
                        ];

                        $progressWidth = $progressMap[$status] ?? 10;
                        $progressColor = $status === 'rejected' ? 'bg-red-500' : 'bg-emerald-500';

                        $appliedDate = $application->applied_at
                            ? \Carbon\Carbon::parse($application->applied_at)->format('M d, Y h:i A')
                            : $application->created_at->format('M d, Y h:i A');
                    @endphp

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
                        <div class="p-6">

                            <!-- Top Section -->
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">
                                <div>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $application->jobPost->jobCategory?->category_name ?? 'Uncategorized' }}
                                        </span>
                                    </div>

                                    <h3 class="text-2xl font-black text-slate-900">
                                        {{ $application->jobPost->title }}
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ $application->jobPost->employer->business_name ?? 'Unknown Employer' }}
                                    </p>
                                </div>

                                <div class="lg:text-right shrink-0">
                                    <p class="text-2xl font-black text-emerald-700">
                                        ₱{{ number_format($application->jobPost->daily_wage, 2) }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        daily wage
                                    </p>
                                </div>
                            </div>

                            <!-- Progress Tracker -->
                            <div class="mt-6">
                                <div class="flex justify-between text-xs font-semibold text-slate-500 mb-2">
                                    <span>Submitted</span>
                                    <span>Reviewed</span>
                                    <span>Result</span>
                                </div>

                                <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-3 {{ $progressColor }} rounded-full transition-all" style="width: {{ $progressWidth }}%"></div>
                                </div>

                                <div class="mt-2 text-sm">
                                    @if ($status === 'pending')
                                        <p class="text-amber-700 font-semibold">
                                            Your application has been submitted and is waiting for employer review.
                                        </p>
                                    @elseif ($status === 'shortlisted')
                                        <p class="text-blue-700 font-semibold">
                                            Good news. You have been shortlisted by the employer.
                                        </p>
                                    @elseif ($status === 'hired')
                                        <p class="text-emerald-700 font-semibold">
                                            Congratulations. You have been marked as hired for this job.
                                        </p>
                                    @elseif ($status === 'rejected')
                                        <p class="text-red-700 font-semibold">
                                            Your application was not selected for this job.
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Job Details -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-6">
                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Location
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $application->jobPost->location ?? 'Not specified' }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Vacancies
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $application->jobPost->vacancies }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Applied At
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $appliedDate }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Expected Wage
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        ₱{{ number_format($application->jobPost->daily_wage, 2) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Skills -->
                            <div class="mt-6">
                                <p class="text-xs text-slate-500 font-semibold uppercase mb-2">
                                    Required Skills
                                </p>

                                <div class="flex flex-wrap gap-2">
                                    @forelse ($application->jobPost->skills as $skill)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                                            {{ $skill->skill_name }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-slate-500">
                                            No required skills listed.
                                        </span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Message and Hiring Info -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                                    <p class="text-xs text-slate-500 font-semibold uppercase mb-2">
                                        Your Message
                                    </p>

                                    <p class="text-slate-700">
                                        {{ $application->message ?: 'No message was provided.' }}
                                    </p>
                                </div>

                                <div class="rounded-2xl border p-5
                                    @if ($status === 'hired')
                                        bg-emerald-50 border-emerald-100
                                    @else
                                        bg-slate-50 border-slate-100
                                    @endif
                                ">
                                    <p class="text-xs font-semibold uppercase mb-2
                                        @if ($status === 'hired')
                                            text-emerald-700
                                        @else
                                            text-slate-500
                                        @endif
                                    ">
                                        Hiring Record
                                    </p>

                                    @if ($status === 'hired' && $application->hiringLog)
                                        <p class="text-slate-700">
                                            Hiring Date:
                                            <strong>{{ \Carbon\Carbon::parse($application->hiringLog->hiring_date)->format('M d, Y') }}</strong>
                                        </p>

                                        <p class="text-slate-700 mt-1">
                                            Actual Wages:
                                            <strong>₱{{ number_format($application->hiringLog->actual_wages_earned ?? 0, 2) }}</strong>
                                        </p>
                                    @else
                                        <p class="text-slate-600">
                                            Hiring details will appear here once the employer marks the application as hired.
                                        </p>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-10 text-center">
                        <div class="mx-auto h-16 w-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xl">
                            —
                        </div>

                        <h3 class="mt-4 font-bold text-slate-900 text-lg">
                            No applications yet.
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Browse available jobs and submit your first application.
                        </p>

                        <a href="{{ route('jobs.index') }}"
                           class="inline-flex mt-5 px-5 py-3 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                            Browse Jobs
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>