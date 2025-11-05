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
        $presentations = Presentation::with('user')->latest()->get();
        return view('presentation.index', compact('presentations'));
    }

    public function create()
    {
        $presentations = Presentation::with('user')->latest()->get();
        return view('presentation.create', compact('presentations'));
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

    return redirect()->route('presentations.index')->with('success', 'Presentation created successfully.');
}

}
