<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Admin Reports Dashboard
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Barangay employment monitoring, hiring records, and wage impact summary.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                    SDG 1 · No Poverty
                </span>

                <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                    Print Report
                </button>
            </div>
        </div>
    </x-slot>

    @php
        $maxZoneHired = max(1, (int) ($zoneStats->max('total_hired') ?? 1));
        $maxZoneWages = max(1, (float) ($zoneStats->max('total_wages_earned') ?? 1));
        $maxMonthlyHired = max(1, (int) ($monthlyStats->max('total_hired') ?? 1));
        $maxMonthlyWages = max(1, (float) ($monthlyStats->max('total_wages') ?? 1));
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Hero Summary -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-700 via-emerald-800 to-blue-900 text-white shadow-xl mb-6">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-20 -left-20 h-72 w-72 rounded-full bg-white"></div>
                    <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-white"></div>
                </div>

                <div class="relative z-10 p-8 md:p-10">
                    <div class="max-w-3xl">
                        <p class="text-sm uppercase tracking-[0.3em] text-emerald-200 font-semibold mb-3">
                            Barangay JobLink Analytics
                        </p>

                        <h1 class="text-3xl md:text-4xl font-black leading-tight">
                            Tracking local employment opportunities for low-income residents.
                        </h1>

                        <p class="mt-4 text-emerald-50 leading-relaxed">
                            This dashboard summarizes job posts, applications, hired residents, and total wages earned.
                            It helps barangay staff monitor livelihood outcomes and support SDG 1: No Poverty.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                        <div class="rounded-2xl bg-white/10 border border-white/15 p-5">
                            <p class="text-sm text-emerald-100">Total Hired</p>
                            <p class="text-3xl font-black mt-1">{{ $summary['total_hired'] }}</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-5">
                            <p class="text-sm text-emerald-100">Total Wages Earned</p>
                            <p class="text-3xl font-black mt-1">
                                ₱{{ number_format($summary['total_wages'] ?? 0, 2) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-5">
                            <p class="text-sm text-emerald-100">Total Applications</p>
                            <p class="text-3xl font-black mt-1">{{ $summary['total_applications'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-4 mb-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Job Seekers
                            </p>
                            <h3 class="text-3xl font-black text-slate-900 mt-2">
                                {{ $summary['total_job_seekers'] }}
                            </h3>
                        </div>

                        <div class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <span class="text-xl font-black">JS</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Employers
                            </p>
                            <h3 class="text-3xl font-black text-slate-900 mt-2">
                                {{ $summary['total_employers'] }}
                            </h3>
                        </div>

                        <div class="h-12 w-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                            <span class="text-xl font-black">EM</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Job Posts
                            </p>
                            <h3 class="text-3xl font-black text-slate-900 mt-2">
                                {{ $summary['total_job_posts'] }}
                            </h3>
                        </div>

                        <div class="h-12 w-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                            <span class="text-xl font-black">JP</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Applications
                            </p>
                            <h3 class="text-3xl font-black text-slate-900 mt-2">
                                {{ $summary['total_applications'] }}
                            </h3>
                        </div>

                        <div class="h-12 w-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center">
                            <span class="text-xl font-black">AP</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Hired
                            </p>
                            <h3 class="text-3xl font-black text-slate-900 mt-2">
                                {{ $summary['total_hired'] }}
                            </h3>
                        </div>

                        <div class="h-12 w-12 rounded-2xl bg-green-50 text-green-700 flex items-center justify-center">
                            <span class="text-xl font-black">HI</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Wages
                            </p>
                            <h3 class="text-xl font-black text-slate-900 mt-2">
                                ₱{{ number_format($summary['total_wages'] ?? 0, 2) }}
                            </h3>
                        </div>

                        <div class="h-12 w-12 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center">
                            <span class="text-xl font-black">₱</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical Defense Panel -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <p class="font-bold text-slate-900">Advanced SQL</p>
                    <p class="text-sm text-slate-500 mt-1">
                        Uses JOIN, LEFT JOIN, COUNT, SUM, GROUP BY, and aggregate reporting.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <p class="font-bold text-slate-900">Audit Trail</p>
                    <p class="text-sm text-slate-500 mt-1">
                        Application status changes are recorded in application logs.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <p class="font-bold text-slate-900">Duplicate Prevention</p>
                    <p class="text-sm text-slate-500 mt-1">
                        Composite unique constraint prevents duplicate applications.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <p class="font-bold text-slate-900">Role-Based Access</p>
                    <p class="text-sm text-slate-500 mt-1">
                        Admin, employer, and job seeker users have separate workflows.
                    </p>
                </div>
            </div>

            <!-- Zone Report -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-xl text-slate-900">
                            Employment and Wages by Barangay Zone
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Shows how many residents were hired and how much wage income was generated per purok/zone.
                        </p>
                    </div>

                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-600">
                        Zone-level impact
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="p-4 text-left">Barangay Zone</th>
                                <th class="p-4 text-left">Total Hired</th>
                                <th class="p-4 text-left">Hiring Progress</th>
                                <th class="p-4 text-left">Total Wages Earned</th>
                                <th class="p-4 text-left">Wage Progress</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach ($zoneStats as $zone)
                                @php
                                    $hiredPercent = min(100, ((int) $zone->total_hired / $maxZoneHired) * 100);
                                    $wagePercent = min(100, ((float) $zone->total_wages_earned / $maxZoneWages) * 100);
                                @endphp

                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-4 font-semibold text-slate-900">
                                        {{ $zone->zone_name }}
                                    </td>

                                    <td class="p-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold">
                                            {{ $zone->total_hired }} hired
                                        </span>
                                    </td>

                                    <td class="p-4 min-w-[180px]">
                                        <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-3 bg-emerald-500 rounded-full" style="width: {{ $hiredPercent }}%"></div>
                                        </div>
                                    </td>

                                    <td class="p-4 font-bold text-slate-900">
                                        ₱{{ number_format($zone->total_wages_earned, 2) }}
                                    </td>

                                    <td class="p-4 min-w-[180px]">
                                        <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-3 bg-blue-500 rounded-full" style="width: {{ $wagePercent }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-200 text-xs text-slate-500">
                    Technical note: This report is generated from multiple related tables using database joins and aggregate functions.
                </div>
            </div>

            <!-- Monthly Report -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="font-bold text-xl text-slate-900">
                        Monthly Hiring Report
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Displays monthly hired residents and total wages earned.
                    </p>
                </div>

                <div class="p-6">
                    @forelse ($monthlyStats as $month)
                        @php
                            $monthHiredPercent = min(100, ((int) $month->total_hired / $maxMonthlyHired) * 100);
                            $monthWagePercent = min(100, ((float) $month->total_wages / $maxMonthlyWages) * 100);
                        @endphp

                        <div class="mb-5 last:mb-0">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-2">
                                <div>
                                    <p class="font-bold text-slate-900">
                                        {{ $month->month }}
                                    </p>
                                    <p class="text-sm text-slate-500">
                                        {{ $month->total_hired }} hired residents
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="font-black text-slate-900">
                                        ₱{{ number_format($month->total_wages, 2) }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        total wages
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <div class="flex justify-between text-xs text-slate-500 mb-1">
                                        <span>Hiring volume</span>
                                        <span>{{ round($monthHiredPercent) }}%</span>
                                    </div>
                                    <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-3 bg-emerald-500 rounded-full" style="width: {{ $monthHiredPercent }}%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-xs text-slate-500 mb-1">
                                        <span>Wage generated</span>
                                        <span>{{ round($monthWagePercent) }}%</span>
                                    </div>
                                    <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-3 bg-blue-500 rounded-full" style="width: {{ $monthWagePercent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="mx-auto h-16 w-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xl">
                                —
                            </div>
                            <p class="mt-4 font-semibold text-slate-700">
                                No monthly hiring data yet.
                            </p>
                            <p class="text-sm text-slate-500">
                                Hiring records will appear after an employer marks an applicant as hired.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>