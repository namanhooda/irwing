<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanctionMemo;
use App\Exports\OfficerWiseParticipationExport;

class OfficerWiseParticipationReportController extends Controller
{
    public function index(Request $request)
    {
        $officer = $request->officer ?? null;

        // Officers dropdown (distinct names)
        $officers = SanctionMemo::select('name')
            ->distinct()
            ->orderBy('name', 'ASC')
            ->pluck('name');

        // Fetch visits for selected officer
        $data = SanctionMemo::select(
                'year',
                'meeting_name',
                'purpose',
                'title',
                'name',
                'date_of_birth',
                'gender',
                'country',
                'city',
                'from_date',
                'to_date'
            )
            ->when($officer, function ($q) use ($officer) {
                $q->where('name', $officer);
            })
            ->orderBy('from_date', 'ASC')
            ->get();

        return view('admin.reports.officer_wise', compact('officer', 'officers', 'data'));
    }

    public function export(Request $request)
    {
        $officer = $request->officer;
        return (new OfficerWiseParticipationExport($officer))
                ->download("officer-participation-$officer.xlsx");
    }
}
