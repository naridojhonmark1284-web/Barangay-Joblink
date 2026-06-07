<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Available Local Jobs
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Browse barangay-based job opportunities and apply directly online.
                </p>
            </div>

            <a href="{{ route('applications.mine') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                My Applications
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Status Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Hero Search Panel -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-700 via-emerald-800 to-blue-900 text-white shadow-xl mb-6">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-20 -left-20 h-72 w-72 rounded-full bg-white"></div>
                    <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-white"></div>
                </div>

                <div class="relative z-10 p-8 md:p-10">
                    <div class="max-w-3xl">
                        <p class="text-sm uppercase tracking-[0.3em] text-emerald-200 font-semibold mb-3">
                            Barangay JobLink
                        </p>

                        <h1 class="text-3xl md:text-4xl font-black leading-tight">
                            Find nearby work opportunities in your community.
                        </h1>

                        <p class="mt-4 text-emerald-50 leading-relaxed">
                            Search jobs by title, location, or description. Apply with one click and track your application status through the system.
                        </p>
                    </div>

                    <form method="GET" action="{{ route('jobs.index') }}" class="mt-8">
                        <div class="flex flex-col md:flex-row gap-3">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search for jobs, skills, or location..."
                                class="w-full rounded-2xl border-0 text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-emerald-300"
                            >

                            <button class="px-6 py-3 rounded-2xl bg-white text-emerald-800 font-bold hover:bg-emerald-50 transition">
                                Search Jobs
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Job Count -->
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-slate-500">
                    Showing available job postings
                </p>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                    {{ $jobs->total() }} open jobs
                </span>
            </div>

            <!-- Job Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @forelse ($jobs as $job)
                    @php
                        $alreadyApplied = in_array($job->id, $appliedJobIds ?? []);
                    @endphp

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
                        <div class="p-6">

                            <!-- Top Row -->
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $job->jobCategory?->category_name ?? 'Uncategorized' }}
                                        </span>

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            {{ ucfirst($job->status) }}
                                        </span>
                                    </div>

                                    <h3 class="text-xl font-black text-slate-900">
                                        {{ $job->title }}
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ $job->employer->business_name ?? 'Unknown Employer' }}
                                    </p>
                                </div>

                                <div class="text-right shrink-0">
                                    <p class="text-xl font-black text-emerald-700">
                                        ₱{{ number_format($job->daily_wage, 2) }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        per day
                                    </p>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="mt-4 text-slate-600 leading-relaxed">
                                {{ $job->description }}
                            </p>

                            <!-- Details -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-5">
                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Location
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $job->location ?? 'Not specified' }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Vacancies
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $job->vacancies }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Deadline
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('M d, Y') : 'No deadline' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Skills -->
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
                                            No specific skills listed
                                        </span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Apply Area -->
                            @if (auth()->user()->role === 'seeker')
                                <div class="mt-6 border-t border-slate-100 pt-5">
                                    @if ($alreadyApplied)
                                        <div class="flex items-center justify-between rounded-2xl bg-emerald-50 border border-emerald-100 p-4">
                                            <div>
                                                <p class="font-bold text-emerald-800">
                                                    Application Submitted
                                                </p>
                                                <p class="text-sm text-emerald-600">
                                                    You have already applied for this job.
                                                </p>
                                            </div>

                                            <a href="{{ route('applications.mine') }}"
                                               class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                                                View Status
                                            </a>
                                        </div>
                                    @else
                                        <form method="POST" action="{{ route('jobs.apply', $job) }}">
                                            @csrf

                                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                Message to Employer <span class="text-slate-400 font-normal">(optional)</span>
                                            </label>

                                            <textarea
                                                name="message"
                                                rows="2"
                                                placeholder="Example: I am available immediately and have experience in this type of work."
                                                class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                                            ></textarea>

                                            <button class="mt-3 w-full md:w-auto px-5 py-3 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                                                Apply Now
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                @empty
                    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 p-10 text-center">
                        <div class="mx-auto h-16 w-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xl">
                            —
                        </div>

                        <h3 class="mt-4 font-bold text-slate-900 text-lg">
                            No open jobs found.
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Try changing your search keyword or check again later.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $jobs->links() }}
            </div>

        </div>
    </div>
</x-app-layout>