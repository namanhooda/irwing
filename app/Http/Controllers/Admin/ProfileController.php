<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Carbon\Carbon;
use App\Models\Designation;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $checkprofile = Profile::where('user_id', Auth::user()->id)->first();
        $designations = Designation::orderBy('name')->get();
        $profile = $checkprofile;

        return view('admin.profile.index', compact('user','profile','checkprofile','designations'));
    }
}
