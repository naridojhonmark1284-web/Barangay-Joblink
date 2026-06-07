<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Employer Dashboard
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Manage job postings, review applications, and track hiring progress.
                </p>
            </div>

            <a href="{{ route('employer.jobs.create') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                Post New Job
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Employer Hero Card -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-700 via-blue-800 to-emerald-900 text-white shadow-xl mb-6">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-20 -left-20 h-72 w-72 rounded-full bg-white"></div>
                    <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-white"></div>
                </div>

                <div class="relative z-10 p-8 md:p-10">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-blue-200 font-semibold mb-3">
                                Employer Workspace
                            </p>

                            <h1 class="text-3xl md:text-4xl font-black leading-tight">
                                {{ $employer->business_name }}
                            </h1>

                            <p class="mt-3 text-blue-50 max-w-3xl leading-relaxed">
                                Post local job opportunities, review applicants, and help connect barangay residents to employment.
                            </p>

                            <div class="flex flex-wrap gap-3 mt-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/10 border border-white/20 text-blue-50">
                                    {{ $employer->business_type ?? 'Business Type Not Set' }}
                                </span>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/10 border border-white/20 text-blue-50">
                                    Contact: {{ $employer->contact_person ?? 'N/A' }}
                                </span>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $employer->is_accredited ? 'bg-emerald-400/20 border-emerald-200/30 text-emerald-100' : 'bg-amber-400/20 border-amber-200/30 text-amber-100' }}">
                                    {{ $employer->is_accredited ? 'Accredited Employer' : 'Pending Accreditation' }}
                                </span>
                            </div>
                        </div>

                        <div class="shrink-0">
                            <a href="{{ route('employer.jobs.create') }}"
                               class="inline-flex px-5 py-3 rounded-2xl bg-white text-blue-800 font-bold hover:bg-blue-50 transition">
                                Create Job Posting
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-8">
                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Total Jobs</p>
                            <p class="text-3xl font-black">{{ $summary['total_jobs'] }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Open Jobs</p>
                            <p class="text-3xl font-black">{{ $summary['open_jobs'] }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Filled Jobs</p>
                            <p class="text-3xl font-black">{{ $summary['filled_jobs'] }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Applications</p>
                            <p class="text-3xl font-black">{{ $summary['total_applications'] }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Hired</p>
                            <p class="text-3xl font-black">{{ $summary['total_hired'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Profile + Quick Guide -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 lg:col-span-2">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-xl text-slate-900">
                                Business Information
                            </h3>
                            <p class="text-sm text-slate-500 mt-1">
                                Employer profile used in job postings.
                            </p>
                        </div>

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            {{ $employer->is_accredited ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                            {{ $employer->is_accredited ? 'Accredited' : 'Not Accredited' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                            <p class="text-xs text-slate-500 font-semibold uppercase">Business Name</p>
                            <p class="font-bold text-slate-900 mt-1">{{ $employer->business_name }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                            <p class="text-xs text-slate-500 font-semibold uppercase">Business Type</p>
                            <p class="font-bold text-slate-900 mt-1">{{ $employer->business_type ?? 'N/A' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                            <p class="text-xs text-slate-500 font-semibold uppercase">Contact Person</p>
                            <p class="font-bold text-slate-900 mt-1">{{ $employer->contact_person ?? 'N/A' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                            <p class="text-xs text-slate-500 font-semibold uppercase">Contact Number</p>
                            <p class="font-bold text-slate-900 mt-1">{{ $employer->contact_number ?? 'N/A' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 font-semibold uppercase">Business Address</p>
                            <p class="font-bold text-slate-900 mt-1">{{ $employer->business_address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="font-bold text-xl text-slate-900">
                        Hiring Workflow
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Step-by-step transaction process.
                    </p>

                    <div class="mt-6 space-y-4">
                        <div class="flex gap-3">
                            <div class="h-9 w-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-black">
                                1
                            </div>
                            <div>
                                <p class="font-bold text-slate-900">Post Job</p>
                                <p class="text-sm text-slate-500">Create local employment opportunity.</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="h-9 w-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-black">
                                2
                            </div>
                            <div>
                                <p class="font-bold text-slate-900">Review Applicants</p>
                                <p class="text-sm text-slate-500">Check skills and application message.</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="h-9 w-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black">
                                3
                            </div>
                            <div>
                                <p class="font-bold text-slate-900">Update Status</p>
                                <p class="text-sm text-slate-500">Shortlist, hire, or reject applications.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Posts -->
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-xl text-slate-900">
                        Job Postings
                    </h3>
                    <p class="text-sm text-slate-500">
                        Manage all job opportunities posted by your business.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @forelse ($jobs as $job)
                    @php
                        $statusClass = [
                            'open' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            'filled' => 'bg-blue-50 text-blue-700 border-blue-100',
                            'closed' => 'bg-slate-50 text-slate-700 border-slate-200',
                        ][$job->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';

                        $hiredPercent = $job->vacancies > 0
                            ? min(100, ($job->hired_applications_count / $job->vacancies) * 100)
                            : 0;
                    @endphp

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                            {{ ucfirst($job->status) }}
                                        </span>

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $job->jobCategory?->category_name ?? 'Uncategorized' }}
                                        </span>
                                    </div>

                                    <h4 class="text-xl font-black text-slate-900">
                                        {{ $job->title }}
                                    </h4>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Posted {{ $job->created_at->format('M d, Y') }}
                                    </p>
                                </div>

                                <div class="text-right shrink-0">
                                    <p class="text-xl font-black text-emerald-700">
                                        ₱{{ number_format($job->daily_wage, 2) }}
                                    </p>
                                    <p class="text-xs text-slate-500">per day</p>
                                </div>
                            </div>

                            <p class="mt-4 text-slate-600 leading-relaxed">
                                {{ $job->description }}
                            </p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">Vacancies</p>
                                    <p class="font-black text-slate-900 mt-1">{{ $job->vacancies }}</p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">Applicants</p>
                                    <p class="font-black text-slate-900 mt-1">{{ $job->applications_count }}</p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">Pending</p>
                                    <p class="font-black text-slate-900 mt-1">{{ $job->pending_applications_count }}</p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">Hired</p>
                                    <p class="font-black text-slate-900 mt-1">{{ $job->hired_applications_count }}</p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="flex justify-between text-xs text-slate-500 font-semibold mb-1">
                                    <span>Hiring progress</span>
                                    <span>{{ $job->hired_applications_count }} / {{ $job->vacancies }}</span>
                                </div>

                                <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-3 bg-emerald-500 rounded-full" style="width: {{ $hiredPercent }}%"></div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <p class="text-xs text-slate-500 font-semibold uppercase mb-2">
                                    Required Skills
                                </p>

                                <div class="flex flex-wrap gap-2">
                                    @forelse ($job->skills as $skill)
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

                            <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-t border-slate-100 pt-5">
                                <div class="text-sm text-slate-500">
                                    Location:
                                    <span class="font-semibold text-slate-700">{{ $job->location ?? 'Not specified' }}</span>
                                </div>

                                <a href="{{ route('employer.jobs.applications', $job) }}"
                                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                                    View Applicants
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 p-10 text-center">
                        <div class="mx-auto h-16 w-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xl">
                            —
                        </div>

                        <h3 class="mt-4 font-bold text-slate-900 text-lg">
                            No job posts yet.
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Start by posting your first local job opportunity.
                        </p>

                        <a href="{{ route('employer.jobs.create') }}"
                           class="inline-flex mt-5 px-5 py-3 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                            Post New Job
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>