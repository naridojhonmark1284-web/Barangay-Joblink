<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangayZone extends Model
{
    protected $fillable = [
        'zone_name',
    ];

    public function jobseekers()
    {
        return $this->hasMany(JobSeeker::class);
    }
    //
}
