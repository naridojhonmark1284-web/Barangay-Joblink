<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
     protected $fillable = [
        'job_post_id',
        'job_seeker_id',
        'status',
        'message',
        'applied_at',
    ];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class);
    }

    public function logs()
    {
        return $this->hasMany(ApplicationLog::class);
    }

    public function hiringLog()
    {
        return $this->hasOne(HiringLog::class);
    }
    //
}
