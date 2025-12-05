<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrpOfficer extends Model
{
    //
    protected $fillable = [
        'qrp_id', 'profile_id', 'staff_no', 'officer_name',
        'unit', 'unit_office', 'division', 'designation',
        'mode', 'email', 'contact',
        'meeting_from', 'meeting_to', 'country', 'city',
        'justification','justification_file','expected_outcome','expected_file',
    ];

    public function qrp(): BelongsTo
    {
        return $this->belongsTo(QrpForm::class , 'id','qrp_id');
    }public function qrpForm()
{
    return $this->belongsTo(QrpForm::class, 'qrp_id');
}


public function profile()
{
    return $this->belongsTo(\App\Models\Profile::class, 'profile_id');
}

}
