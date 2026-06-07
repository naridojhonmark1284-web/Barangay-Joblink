<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BarangayZone;
use App\Models\Employer;
use App\Models\JobSeeker;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(Request $request): View
    {
        $zones = BarangayZone::orderBy('zone_name')->get();

        $defaultType = $request->query('type', 'seeker');

        if (!in_array($defaultType, ['seeker', 'employer'])) {
            $defaultType = 'seeker';
        }

        return view('auth.register', compact('zones', 'defaultType'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Safety fix in case old form sends "job_seeker"
        $request->merge([
            'account_type' => $request->account_type === 'job_seeker'
                ? 'seeker'
                : $request->account_type,
        ]);

        $request->validate([
            'account_type' => ['required', 'in:seeker,employer'],

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Job seeker fields
            'first_name' => ['required_if:account_type,seeker', 'nullable', 'string', 'max:255'],
            'last_name' => ['required_if:account_type,seeker', 'nullable', 'string', 'max:255'],
            'barangay_zone_id' => ['required_if:account_type,seeker', 'nullable', 'exists:barangay_zones,id'],
            'seeker_contact_number' => ['required_if:account_type,seeker', 'nullable', 'string', 'max:30'],
            'address' => ['required_if:account_type,seeker', 'nullable', 'string'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'years_experience' => ['nullable', 'integer', 'min:0'],
            'preferred_daily_wage' => ['nullable', 'numeric', 'min:0'],

            // Employer fields
            'business_name' => ['required_if:account_type,employer', 'nullable', 'string', 'max:255'],
            'business_type' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['required_if:account_type,employer', 'nullable', 'string', 'max:255'],
            'employer_contact_number' => ['required_if:account_type,employer', 'nullable', 'string', 'max:30'],
            'business_address' => ['nullable', 'string'],
        ]);

        $user = DB::transaction(function () use ($request) {
            $accountType = $request->account_type;

            $displayName = $accountType === 'seeker'
                ? trim($request->first_name . ' ' . $request->last_name)
                : $request->contact_person;

            $user = User::create([
                'name' => $displayName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $accountType,
            ]);

            if ($accountType === 'seeker') {
                JobSeeker::create([
                    'user_id' => $user->id,
                    'barangay_zone_id' => $request->barangay_zone_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'contact_number' => $request->seeker_contact_number,
                    'address' => $request->address,
                    'education_level' => $request->education_level,
                    'years_experience' => $request->years_experience ?? 0,
                    'preferred_daily_wage' => $request->preferred_daily_wage,
                    'is_verified' => false,
                ]);
            }

            if ($accountType === 'employer') {
                Employer::create([
                    'user_id' => $user->id,
                    'business_name' => $request->business_name,
                    'business_type' => $request->business_type,
                    'contact_person' => $request->contact_person,
                    'contact_number' => $request->employer_contact_number,
                    'business_address' => $request->business_address,
                    'is_accredited' => false,
                ]);
            }

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
