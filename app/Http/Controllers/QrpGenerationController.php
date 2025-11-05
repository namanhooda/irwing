<?php

namespace App\Http\Controllers;

use App\Models\QrpForm;
use App\Models\Agency;
use App\Models\User;
use App\Models\Profile;
use App\Models\Notification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QrpExport;

class QrpGenerationController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    
    $agencies = Agency::all(); // for dropdown

    $nodalUsers = User::role('nodal')->get(); 
    // base query (with relations if needed)
    $query = QrpForm::with(['agencyy', 'officers'])->latest();

    // ✅ apply ITU/Agency filter
    if ($request->filled('itu')) {
        $query->where('agency', $request->itu); 
        // replace 'agency_id' with the correct column in your qrp_forms table
    }

    // ✅ apply Quarter filter (if you have a quarter column)
    if ($request->filled('quarter')) {
        $query->where('quarter', $request->quarter);
    }
    if ($request->filled('nodal_id')) {
        $query->where('created_by', $request->nodal_id);
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }else{

        $query->where('status', 'Pending');
    }

    $qrps = $query->get();

    return view('qrpgen.indexqrp', compact('qrps', 'agencies','nodalUsers'));
}

    public function qrpIndex($id)
    {
        if($id == 0){

            $agencies = null; 
            $qrps = QrpForm::latest()->get();

        }else{

            $agencies = Agency::find($id); 
            $qrps = QrpForm::where('agency',$agencies->id)->get();

        }
        return view('qrpgen.indexqrp', compact('qrps','agencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(QrpForm $QrpForm, $id)
    {
        $form = QrpForm::findOrFail($id);
        return view('qrpgen.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QrpForm $QrpForm, $id)
    {
        $qrp = QrpForm::findOrFail($id);

        return view('qrpgen.edit', compact('qrp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QrpForm $QrpForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QrpForm $QrpForm)
    {
        //
    }
public function bulkUpdateStatus(Request $request)
{
    // 1. Update status for selected QrpForms
    QrpForm::whereIn('id', $request->selected_ids)
        ->update([
            'status' => $request->status,
        ]);

    // 2. Fetch all updated QrpForms with officers relation
    $qrps = QrpForm::with('officers')
        ->whereIn('id', $request->selected_ids)
        ->get();

    foreach ($qrps as $qrp) {
        foreach ($qrp->officers as $officer) {
            Notification::create([
                'message'  => 'You have an invitation for a meeting. Please fill personal performa.',
                'user_id'  => $officer->profile_id, // adjust if officer has user_id field
                'url'      => url('personal-performa/create?meeting_id=' . $qrp->id),
                'status'   => 'unread',
            ]);
        }
    }
        $adminIds = User::role('admin')->pluck('id'); // uses Spatie's role helper
        $adminProfileIds = Profile::whereIn('user_id', $adminIds)->pluck('id');
        // 2. Create notification for each admin
            foreach ($adminProfileIds as $adminId) {
                Notification::create([
                    'message' => 'A QRP form has been submitted. Please check the details - '.$qrp->meeting_id,
                    'user_id' => $adminId,
                    'url' => url('qrp-generation'),
                    'status' => 'unread',
                ]);
            }

    return redirect()->back()->with('success', 'Status updated and notifications sent.');
}
    // Download as PDF
    public function downloadPdf($id)
    {
        $form = QrpForm::findOrFail($id);

        $pdf = Pdf::loadView('qrp.pdf', compact('form'));
        return $pdf->download('QRP_Form_'.$form->id.'.pdf');
    }
    public function downloadExcel(Request $request, $id = null)
{
    // If an ID is passed, export that one record
    if ($id) {
        return Excel::download(new QrpExport($id), 'QRP_Meeting_'.$id.'.xlsx');
    }

    // Otherwise, export based on filters (for index page)
    $filters = [
        'itu'       => $request->get('itu'),
        'quarter'   => $request->get('quarter'),
        'nodal_id'  => $request->get('nodal_id'),
        'status'    => $request->get('status'),
    ];

    return Excel::download(new QrpExport(null, $filters), 'QRP_Meetings_Filtered.xlsx');
}

}
