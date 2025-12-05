<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BilateralEngagement extends Model
{
    //
    protected $fillable = [
        'country_id',
        'engagement_title',
        'engagement_details',
        'status',
        'meeting_date'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
