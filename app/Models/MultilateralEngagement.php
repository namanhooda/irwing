<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultilateralEngagement extends Model
{

    protected $table = 'multilateral_engagements'; 
    protected $fillable = [
        'country_id',
        'engagement',
        'key_offerings',
        'key_asks',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
