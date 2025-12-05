<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\CountryMissionMastersheet;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CountryMissionExport;

class CountryMissionMastersheetController extends Controller
{
    //
    public function index()
    {
        $missions = CountryMissionMastersheet::with('country')->paginate(20);
        return view('admin.missions.index', compact('missions'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.missions.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
        ]);

        CountryMissionMastersheet::create($request->all());

        return redirect()->route('admin.missions.index')
                         ->with('success', 'Mission record created successfully.');
    }

    public function edit($id)
    {
        $mission = CountryMissionMastersheet::findOrFail($id);
        $countries = Country::orderBy('name')->get();

        return view('admin.missions.edit', compact('mission', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $mission = CountryMissionMastersheet::findOrFail($id);
        $mission->update($request->all());

        return redirect()->route('admin.missions.index')
                         ->with('success', 'Mission updated.');
    }

    public function destroy($id)
    {
        CountryMissionMastersheet::destroy($id);

        return back()->with('success', 'Mission deleted.');
    }

    public function exportExcel()
    {
        return Excel::download(new CountryMissionExport, 'country_mission_mastersheet.xlsx');
    }
}
