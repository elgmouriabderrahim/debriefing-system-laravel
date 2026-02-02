<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'name',
        'promotion_year'
    ];

    public function learners(){
        return $this->hasMany(User::class);
    }

    public function instructors(){
        return $this->belongsToMany(User::class, 'classroom_instructor', 'classroom_id', 'instructor_id');
    }

    public function sprints(){
        return $this->belongsToMany(Sprint::class, 'classroom_sprint');
    }
}