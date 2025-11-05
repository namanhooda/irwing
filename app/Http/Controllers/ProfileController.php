<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Designation;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $profiles = \App\Models\Profile::where('staff_no', 'like', "%{$query}%")
                    ->limit(10)
                    ->get(['id', 'staff_no', 'officer_name']);

                    

        return response()->json($profiles);
    }
    public function profileForm(Request $request)
    {
        $checkprofile = Profile::where('user_id', Auth::user()->id)->first();
    $designations = Designation::orderBy('name')->get();
        $profile = $checkprofile;
        return view('profile.form', compact('checkprofile', 'designations'));
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }

public function updateForm(Request $request)
{
    // ✅ Validate request
    $request->validate([
        'cadre' => 'nullable|string|max:255',
        'designation' => 'nullable|string|max:255',
        'year_of_allotment' => 'nullable|string|max:255',
        'date_of_entry_in_service' => 'nullable|string|max:4',
        'staff_no' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:255',
        'officer_name' => 'nullable|string|max:255',
        'gender' => 'nullable|string|max:20',
        'present_posting' => 'nullable|string|max:255',
        'office_address' => 'nullable|string|max:255',
        'date_of_joining_office' => 'nullable|date',
        'office_phone' => 'nullable|numeric',
        'office_fax' => 'nullable|numeric',
        'office_email' => 'nullable|email|max:255',
        'date_of_birth' => 'nullable|date',
        'native_district' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'educational_qualifications' => 'nullable|string|max:255',
        'languages_known' => 'nullable|string|max:255',
        'date_of_entry_in_present_grade' => 'nullable|date',
        'grade' => 'nullable|string|max:255',
        'rank' => 'nullable|string|max:255',
        'level_in_pay_matrix' => 'nullable|string|max:255',
        'mobile_no' => 'nullable|numeric',
        'email_id' => 'nullable|email|max:255',
        'language' => 'nullable|string|max:255',
        'serving_status' => 'nullable|string|max:255',
    ]);

    // ✅ Fetch the profile
    $profile = Profile::findOrFail($request->id);

    // ✅ Format and assign values safely
    $profile->cadre = $request->cadre;
    $profile->designation = $request->designation;
    $profile->year_of_allotment = $request->year_of_allotment;
    $profile->date_of_entry_in_service = $request->date_of_entry_in_service;
    $profile->staff_no = $request->staff_no;
    $profile->title = $request->title;
    $profile->officer_name = $request->officer_name;
    $profile->gender = $request->gender;
    $profile->present_posting = $request->present_posting;
    $profile->office_address = $request->office_address;

    // ✅ Convert date fields properly
    $profile->date_of_joining_office = $this->formatDate($request->date_of_joining_office);
    $profile->date_of_birth = $this->formatDate($request->date_of_birth);
    $profile->date_of_entry_in_present_grade = $this->formatDate($request->date_of_entry_in_present_grade);

    $profile->office_phone = $request->office_phone;
    $profile->office_fax = $request->office_fax;
    $profile->office_email = $request->office_email;
    $profile->native_district = $request->native_district;
    $profile->state = $request->state;
    $profile->educational_qualifications = $request->educational_qualifications;
    $profile->languages_known = $request->languages_known;
    $profile->grade = $request->grade;
    $profile->rank = $request->rank;
    $profile->level_in_pay_matrix = $request->level_in_pay_matrix;
    $profile->mobile_no = $request->mobile_no;
    $profile->email_id = $request->email_id;
    $profile->language = $request->language;
    $profile->serving_status = $request->serving_status;

    $profile->profile_completed = 'yes';

    // ✅ Save the record
    $profile->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}

/**
 * ✅ Helper function to safely format dates (handles "1988-08-17 00:00:00" issue)
 */
private function formatDate($value)
{
    return $value ? Carbon::parse($value)->format('Y-m-d') : null;
}

}
