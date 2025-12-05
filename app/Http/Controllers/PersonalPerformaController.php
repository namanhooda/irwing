<?php

namespace App\Http\Controllers;

use App\Models\QrpForm;
use App\Models\QrpOfficer;
use App\Models\PersonalPerforma;
use Illuminate\Http\Request;
use App\Models\SanctionMemo;
use App\Models\Country;
use App\Models\Profile;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PersonalPerformaExport;
use Illuminate\Support\Facades\Auth;
use DB;

class PersonalPerformaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $checkprofile = Profile::where('user_id', Auth::user()->id)->first();
        $performas = PersonalPerforma::where('staff_no', $checkprofile->staff_no)->get();
        return view('personalperforma.index', compact('performas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $checkprofile = Profile::where('user_id', Auth::id())->first();
        $tours = SanctionMemo::where('staff_number', $checkprofile->staff_no)->get();

        
        $userId = Auth::id(); // safer and cleaner

        if($request->meeting_id){
            $Qrpdata = QrpOfficer::where('staff_no', $checkprofile->staff_no)->where('qrp_id', $request->meeting_id)->first();
        }else{
            $Qrpdata = null;
        }
        $qrps = QrpForm::with(['agencyy', 'officers'])
            ->whereHas('officers', function ($query) use ($checkprofile) {
                $query->where('profile_id', $checkprofile->id);
            })
            ->whereNotExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                    ->from('personal_performas')
                    ->whereRaw('personal_performas.meeting_id = qrp_forms.id')
                    ->whereRaw('personal_performas.user_id = ?', [$userId]);
            })
            ->orderByRaw("CASE WHEN nodal_status = 'Saved' OR nodal_status IS NULL THEN 0 ELSE 1 END")
            ->get();
        return view('personalperforma.create', compact('qrps','checkprofile','tours','Qrpdata'));
    }
    public function getMeetingData($id)
{
    $userId = Auth::id();
    $profile = Profile::where('user_id', $userId)->first();

    $Qrpdata = QrpOfficer::where('staff_no', $profile->staff_no)
                         ->where('qrp_id', $id)
                         ->first();

    if (!$Qrpdata) {
        return response()->json(['error' => 'No data found'], 404);
    }

    // Decode country JSON
    $countriesArray = json_decode($Qrpdata->country ?? '[]', true);
    $countryIds = collect($countriesArray)->pluck('country')->toArray();
    $countryNames = Country::whereIn('id', $countryIds)->pluck('name')->toArray();
    $countryList = implode(', ', $countryNames);

    return response()->json([
        'event_name'        => $Qrpdata->qrpForm->meeting_name ?? '',
        'event_location'    => $countryList,
        'event_start_date'  => $Qrpdata->meeting_from,
        'event_end_date'    => $Qrpdata->meeting_to,
        'justification'     => $Qrpdata->justification,
        'expected_outcomes' => $Qrpdata->expected_outcome,
    ]);
}


    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
    'title' => 'required',
    'service' => 'required',
    'staff_no' => 'required',
    'designation' => 'required',
    'posting' => 'required',
    'dob' => 'nullable|date',
    'mobile' => 'nullable|string',
    'email' => 'nullable|email',
    'event_name' => 'nullable|string|max:255',
    'event_location' => 'nullable|string|max:255',
    'event_date_from' => 'nullable|date',
    'event_date_to' => 'nullable|date|after_or_equal:event_date_from',
]);

    // File uploads
    $tourReportPath = $request->file('tour_report') 
        ? $request->file('tour_report')->store('tour_reports', 'public') 
        : null;

    $justificationFilePath = $request->file('justification_file') 
        ? $request->file('justification_file')->store('justifications', 'public') 
        : null;
    $performa = PersonalPerforma::create([
        'title' => $request->title,
        'service' => $request->service,
        'service_other' => $request->service_other,
        'staff_no' => $request->staff_no,
        'user_id' => auth()->id(),
        'designation' => $request->designation,
        'posting' => $request->posting,
        'dob' => $request->dob,
        'visits' => $request->visits ? json_encode($request->visits) : null,
        'property_return_date' => $request->property_return_date,
        'pay_level' => $request->pay_level,
        'mobile' => $request->mobile,
        'email' => $request->email,
        'aadhaar' => $request->aadhaar,
        'pan' => $request->pan,
        'tour_report' => $tourReportPath,
        'justification_file' => $justificationFilePath,


        'event_name'      => $request->event_name,
        'event_location'  => $request->event_location,
        'event_date_from' => $request->event_start_date,
        'event_date_to'   => $request->event_end_date,
        'event_brief'     => $request->event_brief,

        'justification' => $request->justification,
        'expected_outcomes' => $request->expected_outcomes,
        'is_itu' => $request->is_itu,
        'itu_current_roles' => $request->itu_current_roles,
        'itu_questions_rapporteur' => $request->itu_questions_rapporteur,
        'itu_questions_associate' => $request->itu_questions_associate,
        'itu_editor_items' => $request->itu_editor_items,
        'itu_previous_roles' => $request->itu_previous_roles,
        'itu_work_items' => $request->itu_work_items,
        'itu_proposed' => $request->itu_proposed,
        'itu_consented' => $request->itu_consented,
        'itu_in_progress' => $request->itu_in_progress,
        'itu_recommendations' => $request->itu_recommendations,
        'itu_reports' => $request->itu_reports,
        'itu_online_meetings' => $request->itu_online_meetings,
        'itu_physical_meetings' => $request->itu_physical_meetings,
        'status' => 'Pending',
    ]);


    return redirect()->route('personal-performa.index')->with('success', 'Personal Performa created successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show(PersonalPerforma $personalPerforma)
    {
        return view('personalperforma.show', compact('personalPerforma'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalPerforma $personalPerforma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonalPerforma $personalPerforma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalPerforma $personalPerforma)
    {
        //
    }
public function exportExcel()
{
    return Excel::download(new PersonalPerformaExport, 'personal_performas.xlsx');
}
public function updateStatus(Request $request, $id)
{
    $performa = PersonalPerforma::findOrFail($id);
    $performa->status = $request->status;
    $performa->save();

    return response()->json(['success' => true]);
}
}
