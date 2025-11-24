<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presentation;
use App\Models\QrpForm;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Country; 

class PresentationController extends Controller
{
    //
    public function index()
    {
        $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();
        if ($activeRole == 'admin') {
            $presentations = Presentation::with('user')->latest()->get();
        }
        else{

            $presentations = Presentation::with('user')->where('user_id', Auth::user()->id)->latest()->get();
        }
        return view('presentation.index', compact('presentations'));
    }

    public function create()
    {
        $userId = Auth::id();
        $profileId = \App\Models\Profile::where('user_id', $userId)->value('id');
        $profile = \App\Models\Profile::where('user_id', $userId)->first();
        $qrps = QrpForm::with(['agencyy', 'officers'])
            ->whereHas('officers', function ($query) use ($profileId) {
                $query->where('profile_id', $profileId);
            })
            ->whereNotExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                    ->from('presentations')
                    ->whereRaw('presentations.tour_id = qrp_forms.id')
                    ->whereRaw('presentations.user_id = ?', [$userId]);
            })
            ->orderByRaw("
                CASE 
                    WHEN nodal_status = 'Saved' OR nodal_status IS NULL THEN 0 
                    ELSE 1 
                END
            ")
            ->get();
        $presentations = Presentation::with('user')->latest()->get();
        return view('presentation.create', compact('presentations','qrps','profile'));
    }
    public function store(Request $request)
{
    $request->validate([
        'tour_id' => 'required|string|max:255',
        'staff_number' => 'nullable|string|max:255',
        'brief' => 'nullable|string|max:255',
        'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:2048',
    ]);
    $filePath = null;
    if ($request->hasFile('file')) {
        // Save file directly in public/presentations
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('presentations'), $fileName);
        $filePath = 'presentations/' . $fileName;
    }

    Presentation::create([
        'tour_id' => $request->tour_id,
        'user_id' => Auth::id(),
        'staff_number' => $request->staff_number,
        'brief' => $request->brief,
        'file' => $filePath,
    ]);

    return redirect()->route('presentation.index')->with('success', 'Presentation created successfully.');
}

}
