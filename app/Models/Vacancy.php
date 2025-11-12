<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file',
        'date',
        'type',
        'status',
    ];
    public function omType()
{
    return $this->belongsTo(OmType::class, 'type', 'id');
}
}
