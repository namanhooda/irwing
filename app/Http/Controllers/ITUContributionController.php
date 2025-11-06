<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ITUContribution;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;use Carbon\Carbon;
use League\Csv\Statement;

class ITUContributionController extends Controller
{
    public function index()
    {
        $contributions = ITUContribution::all();
        return view('itu.index', compact('contributions'));
    }

    public function uploadForm()
    {
        return view('itu.upload');
    }

public function upload(Request $request)
{
    // Validate uploaded CSV
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt|max:2048',
    ]);

    // Read CSV file
    $csv = Reader::createFromPath($request->file('csv_file')->getRealPath(), 'r');
    $csv->setHeaderOffset(0); // First row as header

    foreach ($csv as $record) {
        $rawDate = trim($record['Date of contribution'] ?? '');
        $formattedDate = $this->normalizeDate($rawDate);

        ITUContribution::create([
            'study_group'          => $record['Study Group'] ?? null,
            'question'             => $record['Question'] ?? null,
            'work_item'            => $record['Work item'] ?? null,
            'contribution_type'    => $record['Contribution Type'] ?? null,
            'contribution_brief'   => $record['Contribution in brief'] ?? null,
            'date_of_contribution' => $formattedDate,
            'officers'             => $record['Officer(s) Concerned'] ?? null,
            'status'               => $record['Status of the work item'] ?? null,
            'type'                 => $record['Type'] ?? 'ITU-T',
        ]);
    }

    return redirect()->route('itu_contributions.index')
                     ->with('success', 'CSV imported successfully!');
}

/**
 * Normalize date string to 'Y-m-d' format from various patterns.
 */
private function normalizeDate($rawDate)
{
    if (empty($rawDate)) return null;

    $rawDate = trim($rawDate);
    $rawDate = preg_replace('/\s+/', ' ', $rawDate); // Normalize spaces
    $rawDate = preg_replace('/[()]/', '', $rawDate); // Remove brackets
    $rawDate = str_replace(['For', 'meeting', 'ITU-T', 'SG', ',', 'from', 'to', 'the'], '', $rawDate);

    // 🧠 Try to extract something like "1-10 May 2024" or "6th to 7th November 2024"
    if (preg_match('/(\d{1,2})(st|nd|rd|th)?(-|to)?\s?(\d{0,2})?\s?([A-Za-z]+)\s?(\d{2,4})?/', $rawDate, $matches)) {
        $day = $matches[1] ?? '1';
        $month = $matches[5] ?? null;
        $year = $matches[6] ?? date('Y');

        if ($month) {
            try {
                return Carbon::parse("$day $month $year")->format('Y-m-d');
            } catch (\Exception $e) {}
        }
    }

    // 🧩 Handle formats like "Apr-22" or "May-2023"
    if (preg_match('/([A-Za-z]+)[\s\-\/]?(\d{2,4})/', $rawDate, $matches)) {
        $month = $matches[1];
        $year  = strlen($matches[2]) === 2 ? '20' . $matches[2] : $matches[2];
        try {
            return Carbon::parse("1 $month $year")->format('Y-m-d');
        } catch (\Exception $e) {}
    }

    // 🧩 Handle numeric formats like 5/9/2022 or 31.05.2024
    $clean = str_replace(['.', '-'], '/', $rawDate);
    if (preg_match('/\d{1,2}\/\d{1,2}\/\d{2,4}/', $clean)) {
        try {
            return Carbon::parse($clean)->format('Y-m-d');
        } catch (\Exception $e) {}
    }

    // 🧩 Handle short forms like "3-May-24"
    if (preg_match('/(\d{1,2})[\s\-]?([A-Za-z]+)[\s\-]?(\d{2,4})/', $rawDate, $matches)) {
        $day = $matches[1];
        $month = $matches[2];
        $year = strlen($matches[3]) == 2 ? '20'.$matches[3] : $matches[3];
        try {
            return Carbon::parse("$day $month $year")->format('Y-m-d');
        } catch (\Exception $e) {}
    }

    // 🧩 Fallback: let Carbon try automatically
    try {
        return Carbon::parse($rawDate)->format('Y-m-d');
    } catch (\Exception $e) {
        return null;
    }
}


}
