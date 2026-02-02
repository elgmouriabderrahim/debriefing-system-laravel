<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livrable extends Model
{
    protected $fillable = [
        'content',
        'learner_id',
        'brief_id'
    ];

    public function brief()
    {
        return $this->belongsTo(Brief::class);
    }

    public function learner()
    {
        return $this->belongsTo(User::class, 'learner_id');
    }
}
