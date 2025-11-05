<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OmType;
use Illuminate\Http\Request;

class OmTypeController extends Controller
{
    public function index()
    {
        $omTypes = OmType::latest()->paginate(10);
        return view('admin.om_types.index', compact('omTypes'));
    }

    public function create()
    {
        return view('admin.om_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        OmType::create($request->only('name', 'status'));

        return redirect()->route('admin.om_types.index')->with('success', 'OM Type created successfully.');
    }

    public function edit(OmType $omType)
    {
        return view('admin.om_types.edit', compact('omType'));
    }

    public function update(Request $request, OmType $omType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $omType->update($request->only('name', 'status'));

        return redirect()->route('admin.om_types.index')->with('success', 'OM Type updated successfully.');
    }

    public function destroy(OmType $omType)
    {
        $omType->delete();

        return redirect()->route('admin.om_types.index')->with('success', 'OM Type deleted successfully.');
    }
}
