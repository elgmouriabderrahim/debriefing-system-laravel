<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debriefing extends Model
{
    protected $fillable = [
        'comment',
        
        'instructor_id',
        'learner_id',
        'brief_id'
    ];

    public function brief(){
        return $this->belongsTo(Brief::class);
    }

    public function competences(){
        return $this->belongsToMany(Competence::class, 'competence_debriefing');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function learner()
    {
        return $this->belongsTo(User::class, 'learner_id');
    }
}
