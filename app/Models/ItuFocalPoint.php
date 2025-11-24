<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItuFocalPoint extends Model
{
    //
    protected $fillable = [
        'country_id',
        'city',
        'address',
        'focal_points'
    ];

    public function country() {
        return $this->belongsTo(Country::class);
    }
}
