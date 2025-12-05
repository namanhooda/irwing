<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MultilateralEngagement;
use App\Models\Country;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MultilateralEngagementExport;

class MultilateralEngagementReportController extends Controller
{
    //

    public function index()
    {
        $records = MultilateralEngagement::with('country')->orderBy('id', 'DESC')->get();
        return view('admin.multilateral.index', compact('records'));
    }

    public function create()
    {
        $countries = Country::orderBy('country_name')->get();
        return view('admin.multilateral.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'engagement' => 'required',
        ]);

        MultilateralEngagement::create($request->all());

        return redirect()->route('admin.multilateral.index')->with('success', 'Record Added Successfully!');
    }

    public function edit($id)
    {
        $record = MultilateralEngagement::findOrFail($id);
        $countries = Country::orderBy('country_name')->get();
        return view('admin.multilateral.edit', compact('record', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'engagement' => 'required',
        ]);

        $record = MultilateralEngagement::findOrFail($id);
        $record->update($request->all());

        return redirect()->route('admin.multilateral.index')->with('success', 'Record Updated Successfully!');
    }

    public function destroy($id)
    {
        MultilateralEngagement::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Record Deleted!');
    }

    public function exportExcel()
    {
        return Excel::download(new MultilateralEngagementExport, 'multilateral_engagements.xlsx');
    }

}
