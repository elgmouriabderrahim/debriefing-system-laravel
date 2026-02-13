<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = [

        'label',
        'code',
        'validate'
    ];

    public function briefs(){
        return $this->belongsToMany(Brief::class);
    }

    public function debriefings(){
        return $this->belongsToMany(Debriefing::class);
    }
}
