<?php

use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.reports');
        }

        if ($role === 'employer') {
            return redirect()->route('employer.dashboard');
        }

        return redirect()->route('jobs.index');
    })->name('dashboard');

    // Job seeker routes
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::post('/jobs/{jobPost}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    Route::get('/my-applications', [JobController::class, 'myApplications'])->name('applications.mine');

    // Employer routes
    Route::get('/employer/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
    Route::get('/employer/jobs/create', [EmployerController::class, 'create'])->name('employer.jobs.create');
    Route::post('/employer/jobs', [EmployerController::class, 'store'])->name('employer.jobs.store');
    Route::get('/employer/jobs/{jobPost}/applications', [EmployerController::class, 'applications'])->name('employer.jobs.applications');
    Route::patch('/employer/applications/{application}/status', [EmployerController::class, 'updateStatus'])->name('employer.applications.updateStatus');

    // Admin report route
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports');

    // Breeze profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';