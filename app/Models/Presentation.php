<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'user_id',
        'staff_number',
        'brief',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
