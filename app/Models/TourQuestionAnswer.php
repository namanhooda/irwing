<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourQuestionAnswer extends Model
{
    //
    protected $fillable = ['tour_id', 'question_id', 'answer'];

    public function question() {
        return $this->belongsTo(TourQuestion::class);
    }

    public function tour() {
        return $this->belongsTo(TourReport::class);
    }
}
