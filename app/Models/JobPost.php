<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
     protected $fillable = [
        'employer_id',
        'job_category_id',
        'title',
        'description',
        'daily_wage',
        'vacancies',
        'location',
        'deadline',
        'status',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_post_skill')
            ->withTimestamps();
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    //
}
