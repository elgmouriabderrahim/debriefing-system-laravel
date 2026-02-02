<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = [
        'label',
        'code'
    ];

    public function brief(){
        return $this->belongsToMany(Brief::class, 'brief_competence');
    }

    public function debriefing(){
        return $this->belongsToMany(Debriefing::class, 'competence_debriefing');
    }
}
