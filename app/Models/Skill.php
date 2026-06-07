<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
protected $fillable = [
        'skill_name',
    ];

    public function jobSeekers()
    {
        return $this->belongsToMany(JobSeeker::class, 'job_seeker_skill')
            ->withPivot('proficiency_level')
            ->withTimestamps();
    }

    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'job_post_skill')
            ->withTimestamps();
    }    
    //
}
