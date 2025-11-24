<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Embassy extends Model
{
    //

    protected $fillable = [
        'country',
        'mission_name',
        'address',
        'contact_person',
        'email',
        'phone',
        'website'
    ];
    public function countryData()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }
}
