<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index()
    {
        $informations = Information::latest()->paginate(10);
        return view('admin.informations.index', compact('informations'));
    }

    public function create()
    {
        return view('admin.informations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:10240',
            'url' => 'nullable|url',
        ]);

        $data = $request->only(['title', 'description', 'url']);

        if ($request->hasFile('file')) {
            $fileName = time() . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->move(public_path('uploads/informations'), $fileName);
            $data['file'] = $fileName;
        }

        Information::create($data);

        return redirect()->route('admin.informations.index')->with('success', 'Information added successfully.');
    }

    public function edit(Information $information)
    {
        return view('admin.informations.edit', compact('information'));
    }

    public function update(Request $request, Information $information)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'file' => 'nullable|mimes:pdf|max:10240',
        ]);

        $data = $request->only(['title', 'description', 'url']);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($information->file && file_exists(public_path('uploads/informations/' . $information->file))) {
                unlink(public_path('uploads/informations/' . $information->file));
            }

            $fileName = time() . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->move(public_path('uploads/informations'), $fileName);
            $data['file'] = $fileName;
        }

        $information->update($data);

        return redirect()->route('admin.informations.index')->with('success', 'Information updated successfully.');
    }

    public function destroy(Information $information)
    {
        if ($information->file && file_exists(public_path('uploads/informations/' . $information->file))) {
            unlink(public_path('uploads/informations/' . $information->file));
        }

        $information->delete();

        return redirect()->route('admin.informations.index')->with('success', 'Information deleted successfully.');
    }
}
