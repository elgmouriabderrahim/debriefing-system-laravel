<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brief extends Model
{
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'content',
        'type',
        'instructor_id',
        'sprint_id'
    ];

    public function sprint(){
        return $this->belongsTo(Sprint::class);
    }

    public function livrables(){
        return $this->hasMany(Livrable::class);
    }

    public function competences() {
        return $this->belongsToMany(Competence::class)
                    ->withPivot('level')
                    ->withTimestamps();
    }

    public function debriefings(){
        return $this->hasMany(Debriefing::class);
    }


    public function instructor() 
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}