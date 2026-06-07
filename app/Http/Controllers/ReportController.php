<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Employer;
use App\Models\HiringLog;
use App\Models\JobPost;
use App\Models\JobSeeker;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $summary = [
            'total_job_seekers' => JobSeeker::count(),
            'total_employers' => Employer::count(),
            'total_job_posts' => JobPost::count(),
            'total_applications' => Application::count(),
            'total_hired' => Application::where('status', 'hired')->count(),
            'total_wages' => HiringLog::sum('actual_wages_earned'),
        ];

        // Advanced SQL-style query using joins, aggregate functions, group by
        $zoneStats = DB::table('barangay_zones as bz')
            ->leftJoin('job_seekers as js', 'js.barangay_zone_id', '=', 'bz.id')
            ->leftJoin('applications as a', function ($join) {
                $join->on('a.job_seeker_id', '=', 'js.id')
                    ->where('a.status', '=', 'hired');
            })
            ->leftJoin('hiring_logs as hl', 'hl.application_id', '=', 'a.id')
            ->select(
                'bz.zone_name',
                DB::raw('COUNT(DISTINCT a.id) as total_hired'),
                DB::raw('COALESCE(SUM(hl.actual_wages_earned), 0) as total_wages_earned')
            )
            ->groupBy('bz.id', 'bz.zone_name')
            ->orderByDesc('total_hired')
            ->get();

        $monthlyStats = DB::table('hiring_logs as hl')
            ->join('applications as a', 'a.id', '=', 'hl.application_id')
            ->select(
                DB::raw("DATE_FORMAT(hl.hiring_date, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total_hired'),
                DB::raw('COALESCE(SUM(hl.actual_wages_earned), 0) as total_wages')
            )
            ->where('a.status', 'hired')
            ->groupBy('month')
            ->orderByDesc('month')
            ->get();

        return view('admin.reports', compact('summary', 'zoneStats', 'monthlyStats'));
    }
}