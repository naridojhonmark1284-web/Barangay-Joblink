<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiringLog extends Model
{
    protected $fillable = [
        'application_id',
        'hiring_date',
        'completion_date',
        'actual_wages_earned',
        'is_completed',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    //
}
