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

    public function livrable(){
        return $this->hasOne(Livrable::class);
    }

    public function competences(){
        return $this->belongsToMany(Competence::class, 'brief_competence');
    }

    public function debriefing(){
        return $this->hasOne(Debriefing::class);
    }


    public function instructor() 
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}