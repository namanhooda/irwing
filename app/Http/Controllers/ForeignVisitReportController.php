<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanctionMemo;
use App\Exports\ForeignVisitExport;
use Carbon\Carbon;

class ForeignVisitReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');

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
            ->where('year', $year)
            ->orderBy('from_date', 'ASC')
            ->get();

// Get all distinct years directly from year column
$years = SanctionMemo::select('year')
    ->distinct()
    ->orderBy('year', 'DESC')
    ->pluck('year');

        return view('admin.foreign_visits.index', compact('data', 'years', 'year'));
    }

    public function export(Request $request)
    {
        $year = $request->year ?? date('Y');
        return (new ForeignVisitExport($year))->download("foreign-visits-$year.xlsx");
    }
}
