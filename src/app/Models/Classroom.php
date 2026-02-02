<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'name',
        'year'
    ];

    public function learners(){
        return $this->hasMany(User::class)->where('role', 'learner');
    }

    public function instructors(){
        return $this->belongsToMany(User::class, 'classroom_instructor')->where('role', 'instructor');
    }

    public function sprints(){
        return $this->belongsToMany(Sprint::class, 'classroom_sprint');
    }
}