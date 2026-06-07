<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
     protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'contact_person',
        'contact_number',
        'business_address',
        'is_accredited',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
    //
}
