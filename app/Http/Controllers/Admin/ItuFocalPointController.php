<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItuFocalPoint;
use App\Models\Country;
use Illuminate\Http\Request;

class ItuFocalPointController extends Controller
{
    public function index()
    {
        $data = ItuFocalPoint::with('country')->latest()->paginate(20);
        return view('admin.itu_focal_points.index', compact('data'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.itu_focal_points.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'city'       => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'focal_points' => 'required|string|max:255',
        ]);

        ItuFocalPoint::create($request->all());

        return redirect()->route('admin.itu_focal_points.index')
                         ->with('success', 'Focal Point created successfully!');
    }

    public function edit($id)
    {
        $item = ItuFocalPoint::findOrFail($id);
        $countries = Country::all();

        return view('admin.itu_focal_points.edit', compact('item', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'city'       => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'focal_points' => 'required|string|max:255',
        ]);

        $item = ItuFocalPoint::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('admin.itu_focal_points.index')
                         ->with('success', 'Focal Point updated successfully!');
    }

    public function destroy($id)
    {
        $item = ItuFocalPoint::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Focal Point deleted successfully!');
    }
}