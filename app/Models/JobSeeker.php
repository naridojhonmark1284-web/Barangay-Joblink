<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    protected $fillable = [
        'user_id',
        'barangay_zone_id',
        'first_name',
        'last_name',
        'contact_number',
        'address',
        'education_level',
        'years_experience',
        'preferred_daily_wage',
        'is_verified',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barangayZone()
    {
        return $this->belongsTo(BarangayZone::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_seeker_skill')
            ->withPivot('proficiency_level')
            ->withTimestamps();
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }  //
}
