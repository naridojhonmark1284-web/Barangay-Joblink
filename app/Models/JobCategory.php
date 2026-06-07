<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $fillable = [
        'category_name',
    ];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
    //
}
