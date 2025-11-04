<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Circular;

class CircularController extends Controller
{
    public function index()
    {
        $circulars = Circular::latest()->paginate(10);
        return view('admin.circulars.index', compact('circulars'));
    }

    public function create()
    {
        return view('admin.circulars.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'file'  => 'nullable|mimes:pdf|max:10240', // 10MB
        'url' => 'nullable|url',
        'status' => 'required|in:Active,Inactive',
    ]);

    $data = $request->only(['title', 'description', 'url', 'status']);

    // Handle file upload
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Move file to public/uploads/circulars
        $file->move(public_path('uploads/circulars'), $filename);

        // Save relative path in database (optional)
        $data['file'] = 'uploads/circulars/' . $filename;
    }

    // Create circular
    Circular::create($data);

    return redirect()->route('admin.circulars.index')
        ->with('success', 'Circular added successfully.');
}


    public function edit($id)
    {
        $circular = Circular::findOrFail($id);
        return view('admin.circulars.edit', compact('circular'));
    }

public function update(Request $request, $id)
{
    $circular = Circular::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'file'  => 'nullable|mimes:pdf|max:10240', // 10MB
        'url' => 'nullable|url',
        'status' => 'required|in:Active,Inactive',
    ]);

    $data = $request->only(['title', 'description', 'url', 'status']);

    // Handle file upload if provided
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Move new file to public/uploads/circulars
        $file->move(public_path('uploads/circulars'), $filename);

        // Delete old file if exists
        if (!empty($circular->file) && file_exists(public_path($circular->file))) {
            unlink(public_path($circular->file));
        }

        // Save new file path
        $data['file'] = 'uploads/circulars/' . $filename;
    }

    $circular->update($data);

    return redirect()->route('admin.circulars.index')
        ->with('success', 'Circular updated successfully.');
}

    public function destroy($id)
    {
        Circular::findOrFail($id)->delete();
        return redirect()->route('admin.circulars.index')->with('success', 'Circular deleted successfully.');
    }
}
