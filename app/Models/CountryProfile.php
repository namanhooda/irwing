<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryProfile extends Model
{

    protected $table = 'country_profiles'; 
    protected $fillable = [
        'country_id',
        'capital',
        'official_language',
        'currency',
        'political_structure',
        'economic_overview',
        'bilateral_ties',
        'flag_image',
        'profile_document',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
