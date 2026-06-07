<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'hiring_log_id',
        'reviewer_id',
        'rating',
        'comment',
    ];

    public function hiringLog()
    {
        return $this->belongsTo(HiringLog::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
    //
}
