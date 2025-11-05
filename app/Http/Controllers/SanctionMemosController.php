<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourReport;
use App\Models\QrpForm;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Country; 

class SanctionMemosController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();

        if ($activeRole == 'admin') {
            // Admin sees all reports
            $reports = TourReport::with('user')->latest()->get();
        } else {
            // Non-admin users see only their own reports
            $reports = TourReport::with('user')
                ->where('staff_number', $profile->staff_no)
                ->latest()
                ->get();
        }

        return view('sanctionmemo.index', compact('reports'));
    } 
    public function generatepublic()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();

        if ($activeRole == 'admin') {
            // Admin sees all reports
            $reports = TourReport::with('user')->latest()->get();
        } else {
            // Non-admin users see only their own reports
            $reports = TourReport::with('user')
                ->where('staff_number', $profile->staff_no)
                ->latest()
                ->get();
        }

        return view('sanctionmemo.index', compact('reports'));
    }
}
