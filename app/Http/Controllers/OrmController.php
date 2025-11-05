<?php

namespace App\Http\Controllers;

use App\Models\Orm;
use App\Models\OmType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orm = Orm::get();
        return view('orm.index', compact('orm'));
    }


    public function create()
    {
        $omTypes = OmType::where('status', 1)->get();
        return view('orm.create', compact('omTypes'));
    }

public function store(Request $request)
{
    $request->validate([
        'type' => 'required|exists:om_types,id',
        'title' => 'required|string|max:255',
        'date'  => 'required|date',
        'file'  => 'required|mimes:pdf|max:10240', // 10MB
    ]);

    // make sure the folder exists
    $destinationPath = public_path('file');
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    // create a unique filename
    $fileName = time() . '_' . $request->file('file')->getClientOriginalName();

    // move the file to public/files
    $request->file('file')->move($destinationPath, $fileName);

    // store the relative path in DB (so you can use asset() to show it)
    $filePath = 'file/' . $fileName;

    Orm::create([
        'type' => $request->om_type_id,
        'title' => $request->title,
        'date'  => $request->date,
        'file'  => $filePath,
    ]);

    return redirect()->route('orm-data.index')
                     ->with('success', 'ORM created successfully.');
}

    public function show(Orm $orm)
    {
        return view('orm.show', compact('orm'));
    }

    public function edit(Orm $orm, $id)
    {
        $orm = Orm::find($id);
        $omTypes = OmType::where('status', 1)->get();
        return view('orm.edit', compact('orm','omTypes'));
    }

public function update(Request $request, $id)
{
    $orm = Orm::findOrFail($id);

    $request->validate([
        'type' => 'required|exists:om_types,id',
        'title' => 'required|string|max:255',
        'date'  => 'required|date',
        'file'  => 'nullable|mimes:pdf|max:10240', // optional on update
    ]);

    // Update title and date
    $orm->title = $request->title;
    $orm->date  = $request->date;
    $orm->type  = $request->type;

    // Handle file if uploaded
    if ($request->hasFile('file')) {
        // delete old file if exists
        if ($orm->file && file_exists(public_path($orm->file))) {
            unlink(public_path($orm->file));
        }

        // ensure destination folder exists
        $destinationPath = public_path('file');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // create a unique filename
        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();

        // move file to public/files
        $request->file('file')->move($destinationPath, $fileName);

        // store relative path in DB
        $orm->file = 'file/' . $fileName;
    }

    $orm->save();

    return redirect()->route('orm-data.index')
                     ->with('success', 'ORM updated successfully.');
}

public function destroy(Orm $orm, $id)
{
    $orm = Orm::findOrFail($id);
    // Delete the uploaded file if it exists in public/files
    if ($orm->file && file_exists(public_path($orm->file))) {
        unlink(public_path($orm->file));
    }

    // Delete the DB record
    $orm->delete();

    return redirect()->route('orm-data.index') // or 'orm.index' if that's your route
                     ->with('success', 'ORM deleted successfully.');
}
}
