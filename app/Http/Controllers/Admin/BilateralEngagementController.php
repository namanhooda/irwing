<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BilateralEngagement;
use App\Exports\BilateralEngagementExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Country;
use Illuminate\Http\Request;

class BilateralEngagementController extends Controller
{
    public function index()
    {
        $engagements = BilateralEngagement::with('country')->orderBy('id', 'DESC')->paginate(20);
        return view('admin.bilateral_engagement.index', compact('engagements'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.bilateral_engagement.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'engagement_title' => 'required|string|max:255',
        ]);

        BilateralEngagement::create($request->all());

        return redirect()->route('admin.bilateral-engagement.index')
                         ->with('success', 'Bilateral engagement created successfully.');
    }

    public function edit($id)
    {
        $engagement = BilateralEngagement::findOrFail($id);
        $countries = Country::orderBy('name')->get();

        return view('admin.bilateral_engagement.edit', compact('engagement', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $engagement = BilateralEngagement::findOrFail($id);

        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'engagement_title' => 'required|string|max:255',
        ]);

        $engagement->update($request->all());

        return redirect()->route('admin.bilateral-engagement.index')
                         ->with('success', 'Bilateral engagement updated successfully.');
    }

    public function destroy($id)
    {
        BilateralEngagement::destroy($id);

        return back()->with('success', 'Engagement deleted successfully.');
    }

    public function exportExcel()
    {
        return Excel::download(new BilateralEngagementExport, 'multilateral_engagements.xlsx');
    }
}
