<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryMissionMastersheet extends Model
{
    //

    protected $table = 'country_mission_mastersheet'; 
    protected $fillable = [
        'country_id',
        'india_key_offerings',
        'country_asks',
        'engagement_status',
        'last_meeting_date'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
