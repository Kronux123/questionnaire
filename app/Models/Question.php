<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Questionare;
use App\Models\Answer;
class Question extends Model
{
    protected $fillable = [
        'question',
        'questionare_id'
    ];

    public function questionare()
    {
        return $this->belongsTo(Questionare::class);   
    }

    public function choices()
    {
        return $this->hasMany(Answer::class);
    }
}
