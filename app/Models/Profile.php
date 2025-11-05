<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $fillable = [
    'year_of_allotment',
    'date_of_entry_in_service',
    'staff_no',
    'user_id',
    'officer_name',
    'present_posting',
    'office_address',
    'date_of_joining_office',
    'office_phone',
    'office_fax',
    'office_email',
    'date_of_birth',
    'native_district',
    'state',
    'educational_qualifications',
    'languages_known',
    'date_of_entry_in_present_grade',
    'grade',
    'level_in_pay_matrix',
    'mobile_no',
    'email_id',
    'language',
    'serving_status',
];

protected $casts = [
    'date_of_birth' => 'date',
];
}
