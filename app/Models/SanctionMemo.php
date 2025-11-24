<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanctionMemo extends Model
{
    //
    protected $fillable = [
        'tour_id', 'user_id',
        'staff_number', 'meeting_name', 'purpose', 'service',
        'grade', 'level', 'mobile_no', 'email', 'equivalent_rank',
        'country', 'city', 'from_date', 'to_date',
        'key_contributions', 'follow_up_action_points', 'tour_report_pdf', 'presentation',


        'year',
        'title',
        'name',
        'date_of_birth',
        'gender',
        'designation',
        'cadre',
        'sector',
        'approval_status',
        'vc_status',
        'pc_status',
        'scos_status',
        'pmo_approval',
        'tour_undertaken',
        'office'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
