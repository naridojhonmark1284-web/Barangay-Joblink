<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Applicant Review
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Review applicants, update application status, and record hiring results.
                </p>
            </div>

            <a href="{{ route('employer.dashboard') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                Back to Dashboard
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

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Job Header -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-700 via-blue-800 to-emerald-900 text-white shadow-xl mb-6">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-20 -left-20 h-72 w-72 rounded-full bg-white"></div>
                    <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-white"></div>
                </div>

                <div class="relative z-10 p-8 md:p-10">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-blue-200 font-semibold mb-3">
                                Job Application Management
                            </p>

                            <h1 class="text-3xl md:text-4xl font-black leading-tight">
                                {{ $jobPost->title }}
                            </h1>

                            <p class="mt-3 text-blue-50 max-w-3xl leading-relaxed">
                                {{ $jobPost->description }}
                            </p>

                            <div class="flex flex-wrap gap-3 mt-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/10 border border-white/20 text-blue-50">
                                    ₱{{ number_format($jobPost->daily_wage, 2) }} / day
                                </span>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/10 border border-white/20 text-blue-50">
                                    Vacancies: {{ $jobPost->vacancies }}
                                </span>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/10 border border-white/20 text-blue-50">
                                    Location: {{ $jobPost->location ?? 'Not specified' }}
                                </span>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    @if($jobPost->status === 'open')
                                        bg-emerald-400/20 border-emerald-200/30 text-emerald-100
                                    @elseif($jobPost->status === 'filled')
                                        bg-blue-400/20 border-blue-200/30 text-blue-100
                                    @else
                                        bg-slate-400/20 border-slate-200/30 text-slate-100
                                    @endif
                                ">
                                    {{ ucfirst($jobPost->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="shrink-0 text-left lg:text-right">
                            <p class="text-sm text-blue-100">
                                Deadline
                            </p>
                            <p class="text-2xl font-black">
                                {{ $jobPost->deadline ? \Carbon\Carbon::parse($jobPost->deadline)->format('M d, Y') : 'No Deadline' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-8">
                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Total</p>
                            <p class="text-3xl font-black">{{ $summary['total'] }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Pending</p>
                            <p class="text-3xl font-black">{{ $summary['pending'] }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Shortlisted</p>
                            <p class="text-3xl font-black">{{ $summary['shortlisted'] }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Hired</p>
                            <p class="text-3xl font-black">{{ $summary['hired'] }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-sm text-blue-100">Rejected</p>
                            <p class="text-3xl font-black">{{ $summary['rejected'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applicants -->
            <div class="space-y-5">
                @forelse ($applications as $application)
                    @php
                        $seeker = $application->jobSeeker;
                        $status = $application->status;

                        $statusClass = [
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                            'shortlisted' => 'bg-blue-50 text-blue-700 border-blue-100',
                            'hired' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            'rejected' => 'bg-red-50 text-red-700 border-red-100',
                        ][$status] ?? 'bg-slate-50 text-slate-700 border-slate-100';

                        $appliedDate = $application->applied_at
                            ? \Carbon\Carbon::parse($application->applied_at)->format('M d, Y h:i A')
                            : $application->created_at->format('M d, Y h:i A');
                    @endphp

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
                        <div class="p-6">

                            <!-- Applicant Top -->
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                                <div>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>

                                        @if ($seeker->is_verified)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                Verified Resident
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                                Unverified
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="text-2xl font-black text-slate-900">
                                        {{ $seeker->first_name }} {{ $seeker->last_name }}
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Applied on {{ $appliedDate }}
                                    </p>
                                </div>

                                <div class="shrink-0 lg:text-right">
                                    <p class="text-sm text-slate-500">
                                        Preferred Daily Wage
                                    </p>
                                    <p class="text-2xl font-black text-emerald-700">
                                        ₱{{ number_format($seeker->preferred_daily_wage ?? 0, 2) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Applicant Info -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-6">
                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Contact Number
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $seeker->contact_number }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Barangay Zone
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $seeker->barangayZone->zone_name ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Education
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $seeker->education_level ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase">
                                        Experience
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">
                                        {{ $seeker->years_experience }} year(s)
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mt-6">

                                <!-- Left: Applicant Details -->
                                <div class="space-y-5">
                                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                                        <p class="text-xs text-slate-500 font-semibold uppercase mb-2">
                                            Address
                                        </p>
                                        <p class="text-slate-700">
                                            {{ $seeker->address }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                                        <p class="text-xs text-slate-500 font-semibold uppercase mb-3">
                                            Applicant Skills
                                        </p>

                                        <div class="flex flex-wrap gap-2">
                                            @forelse ($seeker->skills as $skill)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-slate-200 text-slate-700 text-xs font-semibold">
                                                    {{ $skill->skill_name }}
                                                    @if ($skill->pivot?->proficiency_level)
                                                        <span class="ml-1 text-slate-400">
                                                            · {{ ucfirst($skill->pivot->proficiency_level) }}
                                                        </span>
                                                    @endif
                                                </span>
                                            @empty
                                                <span class="text-sm text-slate-500">
                                                    No skills listed.
                                                </span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                                        <p class="text-xs text-slate-500 font-semibold uppercase mb-2">
                                            Applicant Message
                                        </p>

                                        <p class="text-slate-700">
                                            {{ $application->message ?: 'No message provided by the applicant.' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Right: Status Update Form -->
                                <div class="rounded-2xl border border-slate-200 p-5">
                                    <h4 class="font-bold text-lg text-slate-900">
                                        Update Application Status
                                    </h4>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Status changes are saved to the application logs for transparency.
                                    </p>

                                    <form method="POST" action="{{ route('employer.applications.updateStatus', $application) }}" class="mt-5">
                                        @csrf
                                        @method('PATCH')

                                        <div class="mb-4">
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                Status
                                            </label>

                                            <select name="status"
                                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                                @foreach (['pending', 'shortlisted', 'hired', 'rejected'] as $option)
                                                    <option value="{{ $option }}" @selected($application->status === $option)>
                                                        {{ ucfirst($option) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                Actual Wages Earned
                                            </label>

                                            <input
                                                type="number"
                                                step="0.01"
                                                name="actual_wages_earned"
                                                value="{{ $application->hiringLog?->actual_wages_earned ?? $jobPost->daily_wage }}"
                                                class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                                            >

                                            <p class="text-xs text-slate-500 mt-1">
                                                This is recorded when status is set to hired.
                                            </p>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                Remarks
                                            </label>

                                            <textarea
                                                name="remarks"
                                                rows="3"
                                                placeholder="Example: Applicant passed interview and is available immediately."
                                                class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                                            ></textarea>
                                        </div>

                                        <button class="w-full px-5 py-3 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                                            Save Status Update
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Hiring Record -->
                            @if ($application->status === 'hired' && $application->hiringLog)
                                <div class="mt-6 rounded-2xl bg-emerald-50 border border-emerald-100 p-5">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                        <div>
                                            <p class="text-xs text-emerald-700 font-semibold uppercase">
                                                Hiring Record
                                            </p>

                                            <h4 class="font-black text-emerald-900 text-lg mt-1">
                                                Applicant has been hired
                                            </h4>

                                            <p class="text-sm text-emerald-700 mt-1">
                                                Hiring date:
                                                {{ \Carbon\Carbon::parse($application->hiringLog->hiring_date)->format('M d, Y') }}
                                            </p>
                                        </div>

                                        <div class="md:text-right">
                                            <p class="text-sm text-emerald-700">
                                                Actual Wages Earned
                                            </p>

                                            <p class="text-2xl font-black text-emerald-900">
                                                ₱{{ number_format($application->hiringLog->actual_wages_earned ?? 0, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Audit Trail -->
                            <div class="mt-6 border-t border-slate-100 pt-5">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <h4 class="font-bold text-slate-900">
                                            Status Logs / Audit Trail
                                        </h4>
                                        <p class="text-sm text-slate-500">
                                            Every application status change is recorded here.
                                        </p>
                                    </div>

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $application->logs->count() }} log(s)
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    @forelse ($application->logs->sortByDesc('created_at') as $log)
                                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                                <div>
                                                    <p class="font-semibold text-slate-900">
                                                        {{ $log->old_status ?? 'none' }}
                                                        <span class="text-slate-400">→</span>
                                                        {{ $log->new_status }}
                                                    </p>

                                                    <p class="text-sm text-slate-500 mt-1">
                                                        Updated by {{ $log->changedBy->name ?? 'Unknown User' }}
                                                    </p>

                                                    @if ($log->remarks)
                                                        <p class="text-sm text-slate-700 mt-2">
                                                            “{{ $log->remarks }}”
                                                        </p>
                                                    @endif
                                                </div>

                                                <div class="md:text-right text-sm text-slate-500">
                                                    {{ $log->created_at->format('M d, Y h:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 text-sm text-slate-500">
                                            No audit logs yet.
                                        </div>
                                    @endforelse
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
                            No applicants yet.
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Applications will appear here once job seekers apply to this job post.
                        </p>

                        <a href="{{ route('employer.dashboard') }}"
                           class="inline-flex mt-5 px-5 py-3 rounded-2xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition">
                            Back to Dashboard
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>