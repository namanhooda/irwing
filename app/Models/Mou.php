<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mou extends Model
{
    protected $fillable = [
        'country_id',
        'mou_title',
        'signed_date',
        'mou_file',
        'remarks',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
