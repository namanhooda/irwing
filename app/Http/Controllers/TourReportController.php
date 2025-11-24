<?php

namespace App\Http\Controllers;

use App\Models\TourReport;
use Illuminate\Http\Request;
use App\Models\QrpForm;
use App\Models\TourQuestionAnswer;
use App\Models\TourQuestion;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Country; 

class TourReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view('tour_reports.index', compact('reports'));
    }
    public function view()
    {
        $reports = TourReport::with('user')->latest()->get();
        return view('tour_reports.view', compact('reports'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $userId = Auth::id();
        $profileId = \App\Models\Profile::where('user_id', $userId)->value('id');

        $qrps = QrpForm::with(['agencyy', 'officers'])
            ->whereHas('officers', function ($query) use ($profileId) {
                $query->where('profile_id', $profileId);
            })
            ->whereNotExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                    ->from('tour_reports')
                    ->whereRaw('tour_reports.tour_id = qrp_forms.id')
                    ->whereRaw('tour_reports.user_id = ?', [$userId]);
            })
            ->orderByRaw("
                CASE 
                    WHEN nodal_status = 'Saved' OR nodal_status IS NULL THEN 0 
                    ELSE 1 
                END
            ")
            ->get();

        $user = Auth::user();
        $profile = \App\Models\Profile::where('user_id', $userId)->first();
        $questions = TourQuestion::get();

        // Fetch additional data from other related tables if needed
        $autoData = [
            'staff_number' => $profile->staff_no ?? '',
            'meeting_name' => $user->meeting_name ?? '',
            'purpose' => $user->purpose ?? '',
            'service' => $user->service ?? '',
            'name_designation' => $profile->officer_name ?? '',
            'grade' => $profile->grade ?? '',
            'level' => $profile->level_in_pay_matrix ?? '',
            'mobile_no' => $profile->mobile_no ?? '',
            'email' => $profile->email_id ?? '',
            'equivalent_rank' => $profile->rank ?? '',
            'country' => $user->country ?? '',
            'city' => $user->city ?? '',
            'from_date' => $user->from_date ?? null,
            'to_date' => $user->to_date ?? null,
        ];

        return view('tour_reports.create', compact('autoData','qrps','questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'tour_id' => 'required|unique:tour_reports,tour_id',
        'meeting_name' => 'required|string',
        'purpose' => 'required|string',
        'from_date' => 'required|date',
        'to_date' => 'required|date',
        'key_contributions' => 'required|string|max:1000',
        'follow_up_action_points' => 'required|string|max:1000',
        'tour_report_pdf' => 'nullable|mimes:pdf|max:2048',
    ]);

    $user = Auth::user();

    $data = [
        'tour_id' => $request->tour_id,
        'user_id' => $user->id,

        'staff_number' => $request->staff_no,
        'meeting_name' => $request->meeting_name,
        'purpose' => $request->purpose,
        'service' => $request->service,
        'name_designation' => $request->name_designation,
        'grade' => $request->grade,
        'level' => $request->level,
        'mobile_no' => $request->mobile_no,
        'email' => $request->email,
        'equivalent_rank' => $request->equivalent_rank,
        'country' => $request->country,
        'city' => $request->city,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date,

        'key_contributions' => $request->key_contributions,
        'follow_up_action_points' => $request->follow_up_action_points,
        'presentation' => $request->presentation,
    ];

    if ($request->hasFile('tour_report_pdf')) {
        $data['tour_report_pdf'] = $request->file('tour_report_pdf')->store('tour_reports', 'public');
    }

    $tourReport = TourReport::create($data);if ($request->has('answers')) {
    foreach ($request->answers as $questionId => $answer) {
        \App\Models\TourQuestionAnswer::create([
            'tour_id' => $tourReport->id,
            'question_id' => $questionId,
            'answer' => $answer,
        ]);
    }
}

    return redirect()->route('tour-reports.index')->with('success', 'Tour Report submitted successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(TourReport $tourReport, $id)
    {
        // Load all answers related to this tour report

        $tourReport = TourReport::find($id);
        $answers = \App\Models\TourQuestionAnswer::with('question')
                    ->where('tour_id', $id)
                    ->get();

        return view('tour_reports.show', compact('tourReport', 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourReport $tourReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourReport $tourReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourReport $tourReport)
    {
        //
    }public function getMeetingDates($id)
{
    $meeting = \App\Models\QrpForm::find($id);

    if (!$meeting) {
        return response()->json(['error' => 'Meeting not found'], 404);
    }

    $countryIds = [];
    $cities = [];

    if (!empty($meeting->country)) {
        $countryData = json_decode($meeting->country, true);

        if (is_array($countryData)) {
            foreach ($countryData as $entry) {
                if (!empty($entry['country'])) {
                    $countryIds[] = $entry['country'];
                }
                if (!empty($entry['city'])) {
                    $cities[] = $entry['city'];
                }
            }
        }
    }  

    $countryNames = Country::whereIn('id', $countryIds)->pluck('name')->toArray();
    return response()->json([
        'meeting_name' => $meeting->meeting_name,
        'from_date' => $meeting->meeting_from,
        'to_date' => $meeting->meeting_to,
        'country'      => implode(', ', $countryNames),
        'city'         => implode(', ', $cities),
        'purpose'      => $meeting->justification,
    ]);
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt'
    ]);

    $file = fopen($request->file('file')->getRealPath(), 'r');
    $header = fgetcsv($file);

    $formatDate = function ($date) {
        if (!$date) return null;
        $date = trim($date);
        $formats = ['d.m.Y', 'd/m/Y', 'Y-m-d', 'd-m-Y', 'm/d/Y'];
        foreach ($formats as $format) {
            $dt = \DateTime::createFromFormat($format, $date);
            if ($dt) return $dt->format('Y-m-d');
        }
        $timestamp = strtotime($date);
        return $timestamp ? date('Y-m-d', $timestamp) : null;
    };

    while (($row = fgetcsv($file)) !== false) {
        // Convert all fields to UTF-8
        $row = array_map(fn($value) => mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1'), $row);


        TourReport::create([
            'tour_id'          => $row[19] ?? null,
            'year'             => $row[3] ?? null,
            'staff_number'     => $row[7] ?? null,
            'meeting_name'     => $row[4] ?? null,
            'purpose'          => $row[20] ?? null,
            'title'            => $row[8] ?? null,
            'name'             => $row[1] ?? null,
            'date_of_birth'    => $formatDate($row[9] ?? null),
            'gender'           => $row[10] ?? null,
            'designation'      => $row[2] ?? null,
            'grade'            => $row[12] ?? null,
            'level'            => $row[14] ?? null,
            'equivalent_rank'  => $row[13] ?? null,
            'country'          => $row[6] ?? null,
            'city'             => $row[18] ?? null,
            'from_date'        => $formatDate($row[16] ?? null),
            'to_date'          => $formatDate($row[17] ?? null),
            'cadre'            => $row[11] ?? null,
            'sector'           => $row[22] ?? null,
            'approval_status'  => $row[23] ?? null,
            'vc_status'        => $row[24] ?? null,
            'pc_status'        => $row[25] ?? null,
            'scos_status'      => $row[26] ?? null,
            'pmo_approval'     => $row[27] ?? null,
            'tour_undertaken'  => $row[28] ?? null,
            'office'           => $row[15] ?? null,
        ]);
    }

    fclose($file);

    return back()->with('success', 'CSV imported successfully with proper encoding and date formatting!');
}


}
