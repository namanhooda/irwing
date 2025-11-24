<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Profile;
use App\Models\News;
use App\Models\User;
use App\Models\QrpForm;
use App\Models\Blog;
use App\Models\SanctionMemo;
use App\Models\ITUContribution;
use Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $checkprofile = Profile::where('user_id', Auth::user()->id)->first();
        // if($checkprofile->profile_completed == null){

        // return redirect()->route('profile.complete')->with('success', 'Please Complete profile.');

        // }


        $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();

        if($activeRole == 'Officer'){

            $tourReport = SanctionMemo::with('user')->where('staff_number', $checkprofile->staff_no)->latest()->get();

        }else{

            $tourReport = SanctionMemo::with('user')->latest()->get();

        }

        $totalQrps     = QrpForm::count();
        $pendingQrps   = QrpForm::where('status', 'pending')->count();
        $approvedQrps  = QrpForm::where('status', 'approved')->count();
        $rejectedQrps  = QrpForm::where('status', 'rejected')->count();

        // Distinct list of officer names for the filter dropdown
        $officers = SanctionMemo::select('name')
            ->whereNotNull('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');

        return view('dashboard', compact('tourReport', 'officers','totalQrps', 'pendingQrps', 'approvedQrps', 'rejectedQrps'));
    }
    public function index2(Request $request)
    {

        $ITUContribution = ITUContribution::get();

        return view('dashboard2', compact('ITUContribution'));
    }
}
