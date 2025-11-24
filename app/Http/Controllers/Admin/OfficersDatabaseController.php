<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SanctionMemo;
use App\Models\Profile;

class OfficersDatabaseController extends Controller
{
    //
    public function index()
    {
        $officers = SanctionMemo::select(
            'staff_number',
            'name',
            'date_of_birth',
            'gender',
            \DB::raw('COUNT(tour_id) as total_tours')
        )
        ->groupBy('staff_number', 'name', 'date_of_birth', 'gender')
        ->orderBy('name')
        ->get();
        return view('admin.officers_database.index', compact('officers'));
    }
    public function view($staff_no)
    {
        $query = SanctionMemo::with('user');
        $checkprofile = Profile::where('staff_no', $staff_no)->first();

        $query->where('staff_number', $staff_no);

        $reports = $query->latest()->get();
        
        return view('admin.officers_database.view', compact('reports','checkprofile'));
    }
}
