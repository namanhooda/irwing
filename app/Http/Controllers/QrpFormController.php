<?php

namespace App\Http\Controllers;

use App\Models\QrpForm;
use App\Models\QrpOfficer;
use App\Models\Unit;
use App\Models\Profile;
use App\Models\Agency;
use App\Models\ITUSector;
use App\Models\Designation;
use App\Models\ITUSectorGroup;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\User;
use Auth;

class QrpFormController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qrps = QrpForm::latest()->get();
        $qrps = QrpForm::with(['agencyy','officers'])
        ->orderByRaw("CASE WHEN nodal_status = 'Saved' OR nodal_status IS NULL THEN 0 ELSE 1 END")
        ->get();
        return view('qrp.index', compact('qrps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agencies = Agency::all(); 
        $sectors = ITUSector::all(); 
        $sectorGroups = ITUSectorGroup::all();
        $country = Country::all();
        
        $units = Unit::all();
        $profiles = Profile::select('id', 'officer_name')->get();
        $designations = Designation::latest()->get();
        return view('qrp.create', compact('profiles','agencies', 'sectors', 'sectorGroups','country','units','designations'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // ✅ Validate the input
    $validated = $request->validate([
        'agency' => 'required|integer',
        'itu_sector' => 'required|integer',
        'sector_group' => 'required|integer',
        'meeting_name' => 'required|string|max:255',
        'meeting_from' => 'required|date',
        'meeting_to' => 'required|date|after_or_equal:meeting_from',
        'countries' => 'required|array|min:1', // multiple countries
        'countries.*.country' => 'required|integer',
        'countries.*.city' => 'required|string|max:255',
        'similar_meeting' => 'nullable|string',

        // Officer array validation
        'officers' => 'required|array|min:1',
        'officers.*.profile_id' => 'nullable|integer',
        'officers.*.staff_no' => 'nullable|string|max:50',
        'officers.*.officer_name' => 'required|string|max:255',
        'officers.*.unit' => 'nullable|integer',
        'officers.*.unit_office' => 'nullable|integer',
        'officers.*.division' => 'nullable|integer',
        'officers.*.designation' => 'nullable|integer',
        'officers.*.mode' => 'required|in:Online,Offline',
        'officers.*.email' => 'nullable|email',
        'officers.*.contact' => 'nullable|string|max:20',
        'officers.*.meeting_from' => 'required|date',
        'officers.*.meeting_to' => 'required|date|after_or_equal:officers.*.meeting_from',


        'officers.*.justification' => 'nullable|string',
        'officers.*.expected_outcome' => 'nullable|string',

        'officers.*.countries' => 'required|array|min:1',
        'officers.*.countries.*.country' => 'required|integer',
        'officers.*.countries.*.city' => 'required|string|max:255',

        // Optional file validations
        'invitation_letter' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        'previous_report' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        'officers.*.justification_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        'officers.*.expected_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
    ]);

    try {
        DB::beginTransaction();

        $quaterdate = Carbon::parse($request->meeting_from);
        $quarter = $quaterdate->quarter;

        $quarterLabels = [
            1 => 'Quater 1 (Jan-Mar)',
            2 => 'Quater 2 (Apr-Jun)',
            3 => 'Quater 3 (Jul-Sep)',
            4 => 'Quater 4 (Oct-Dec)',
        ];

        $yearquater = $quarterLabels[$quarter];
        $data = $validated;
        $data['meeting_id'] = $this->generateMeetingId();
        $data['nodal_status'] = 'Saved';
        $data['quarter'] = $yearquater;
        $data['created_by'] = Auth::user()->id;

        // ✅ Handle main form files
        foreach (['invitation_letter', 'previous_report'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $data[$fileKey] = $request->file($fileKey)->store('qrp_files');
            }
        }

        // ✅ JSON encode multiple countries + cities
        if ($request->has('countries')) {
            $data['country'] = json_encode($request->input('countries'));
        } 
        // ✅ Create main QRP form
        $qrp = QrpForm::create($data);

        // ✅ Create officers linked to the QRP form
        foreach ($validated['officers'] as $index => $officer) {

            // Handle officer files
            $justificationFile = $expectedFile = null;
            if ($request->hasFile("officers.$index.justification_file")) {
                $justificationFile = $request->file("officers.$index.justification_file")->store('qrp_files');
            }
            if ($request->hasFile("officers.$index.expected_file")) {
                $expectedFile = $request->file("officers.$index.expected_file")->store('qrp_files');
            }

            QrpOfficer::create([
                'qrp_id' => $qrp->id,
                'profile_id' => $officer['profile_id'] ?? null,
                'staff_no' => $officer['staff_no'] ?? null,
                'officer_name' => $officer['officer_name'],
                'unit' => $officer['unit'] ?? null,
                'unit_office' => $officer['unit_office'] ?? null,
                'division' => $officer['division'] ?? null,
                'designation' => $officer['designation'] ?? null,
                'mode' => $officer['mode'] ?? 'Online',
                'email' => $officer['email'] ?? null,
                'contact' => $officer['contact'] ?? null,
                'meeting_from' => $officer['meeting_from'],
                'meeting_to' => $officer['meeting_to'],
                'country' => isset($officer['countries']) ? json_encode($officer['countries']) : null,
                'justification' => $officer['justification'] ?? null,
                'justification_file' => $justificationFile,
                'expected_outcome' => $officer['expected_outcome'] ?? null,
                'expected_file' => $expectedFile,
            ]);
        }
        DB::commit();


        return redirect()->route('qrp.index')->with('success', 'Form saved successfully.');

    } catch (\Exception $e) {
        dd($e);
        DB::rollBack();
        Log::error('QRP form submission failed', ['error' => $e->getMessage()]);
        return back()->with('error', 'Something went wrong while submitting the form.'.$e->getMessage())->withInput();
    }
}

    /**
     * Generate unique meeting_id
     */
    private function generateMeetingId()
    {
        do {
            // Example: A12, Z45, K07
            $meetingId = chr(rand(65, 90)) . rand(10, 99);
        } while (QrpForm::where('meeting_id', $meetingId)->exists());

        return $meetingId;
    }

    /**
     * Display the specified resource.
     */
    public function show(QrpForm $QrpForm, $id)
    {
        $form = QrpForm::findOrFail($id);
        return view('qrp.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit($id)
{
    $qrp = QrpForm::with('officers')->findOrFail($id);

    $agencies = Agency::all(); 
    $sectors = ITUSector::all(); 
    $sectorGroups = ITUSectorGroup::all();
    $country = Country::all();
    $units = Unit::all();

    return view('qrp.edit', compact('qrp','agencies','sectors','sectorGroups','country','units'));
}

public function update(Request $request, $id)
{
    $qrp = QrpForm::findOrFail($id);

    $validated = $request->validate([
        'agency' => 'required|integer',
        'itu_sector' => 'required|integer',
        'sector_group' => 'required|integer',
        'itu_type' => 'required|string',
        'meeting_name' => 'required|string|max:255',
        'meeting_from' => 'required|date',
        'meeting_to' => 'required|date|after_or_equal:meeting_from',
        'country' => 'required|integer',
        'city' => 'required|string|max:255',

        'justification' => 'nullable|string',
        'expected_outcome' => 'nullable|string',

        // officers
        'officers' => 'required|array|min:1',
        'officers.*.profile_id' => 'nullable|integer',
        'officers.*.staff_no' => 'nullable|string|max:50',
        'officers.*.officer_name' => 'required|string|max:255',
        'officers.*.unit' => 'nullable|integer',
        'officers.*.unit_office' => 'nullable|integer',
        'officers.*.division' => 'nullable|integer',
        'officers.*.designation' => 'nullable|integer',
        'officers.*.mode' => 'required|in:Online,Offline',
        'officers.*.email' => 'nullable|email',
        'officers.*.contact' => 'nullable|string|max:20',
        'officers.*.meeting_from' => 'required|date',
        'officers.*.meeting_to' => 'required|date|after_or_equal:officers.*.meeting_from',
        'officers.*.country' => 'nullable|integer',
        'officers.*.city' => 'nullable|string|max:255',

        // files
        'invitation_letter' => 'nullable|file|mimes:pdf,doc,docx',
        'previous_report' => 'nullable|file|mimes:pdf,doc,docx',
        'justification_file' => 'nullable|file|mimes:pdf,doc,docx',
        'expected_file' => 'nullable|file|mimes:pdf,doc,docx',
    ]);

    DB::beginTransaction();
    try {
        $data = $validated;

        // Handle file updates
        foreach (['invitation_letter','previous_report','justification_file','expected_file'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $data[$fileKey] = $request->file($fileKey)->store('qrp_files');
            } else {
                unset($data[$fileKey]); // prevent overwriting with null
            }
        }

        $qrp->update($data);

        // Officers: delete old + re-insert (simplest approach)
        $qrp->officers()->delete();
        foreach ($validated['officers'] as $officer) {
            $qrp->officers()->create($officer);
        }

        DB::commit();
        
        return redirect()->route('qrp.index')->with('success', 'QRP updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage())->withInput();
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QrpForm $QrpForm)
    {
        //
    }
    // Download as PDF
    public function downloadPdf($id)
    {
        $form = QrpForm::findOrFail($id);

        $pdf = Pdf::loadView('qrp.pdf', compact('form'));
        return $pdf->download('QRP_Form_'.$form->id.'.pdf');
    }
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Pending,Approved,Rejected',
    ]);

    $form = QrpForm::findOrFail($id);
    $form->status = $request->status;
    $form->save();

    return redirect()->back()->with('success', 'Status updated successfully!');
}
public function bulkSubmit(Request $request)
{
    $request->validate([
        'qrp_ids' => 'required|array',
    ]);

    // Update status of selected QRPs
    \App\Models\QrpForm::whereIn('id', $request->qrp_ids)
        ->update(['nodal_status' => 'Submitted','status' => 'Pending']);

    return redirect()->back()->with('success', 'Selected QRPs have been submitted.');
}
}
