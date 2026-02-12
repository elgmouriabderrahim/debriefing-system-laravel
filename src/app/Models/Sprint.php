<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    protected $fillable = [
        'name',
        'duration_days',
        'order'
    ];

    public function briefs()
    {
        return $this->hasMany(Brief::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_sprint');
    }
}