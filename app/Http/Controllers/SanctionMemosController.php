<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourReport;
use App\Models\QrpForm;
use App\Models\QrpOfficer;
use App\Models\User;
use App\Models\Profile;
use App\Models\ITUSector;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Models\Country; 

class SanctionMemosController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();

        if ($activeRole == 'admin') {
            // Admin sees all reports
            $reports = TourReport::with('user')->latest()->get();
        } else {
            // Non-admin users see only their own reports
            $reports = TourReport::with('user')
                ->where('staff_number', $profile->staff_no)
                ->latest()
                ->get();
        }

        return view('sanctionmemo.index', compact('reports'));
    } 
public function generate($id)

{
    $qrp = QrpForm::findOrFail($id);


    $alreadyExists = TourReport::where('tour_id', $qrp->meeting_id)->exists();
    // if ($alreadyExists) {
    //     return back()->with('error', 'Sanction memo already generated for this tour.');
    // }

    $officers = QrpOfficer::where('qrp_id', $qrp->id)->get();
    $officerdd = QrpOfficer::where('qrp_id', $qrp->id)->first();
    $records = [];

    foreach ($officers as $officer) {

        $profile = Profile::where('staff_no', $officer->staff_no)->first();
        if (!$profile) continue;

        $user = User::find($profile->user_id);

        // Decode meeting country/city info
        $firstLocation = null;
        if (!empty($qrp->country)) {
            $locations = json_decode($qrp->country, true);
            $firstLocation = $locations[0] ?? null;
        }

        $countryname = Country::find($firstLocation['country'] ?? null);
        $itusector   = ITUSector::find($qrp->itu_sector);

        // Build data
        $data = [
            'tour_id'        => $qrp->meeting_id,
            'user_id'        => $user->id ?? null,
            'purpose'        => "Multilateral",
            'staff_number'   => $officer->staff_no,
            'meeting_name'   => $qrp->meeting_name,
            'service'        => $profile->service,
            'title'          => $profile->title,
            'name'           => $profile->officer_name,
            'date_of_birth'  => $profile->date_of_birth,
            'gender'         => $profile->gender,
            'designation'    => $profile->designation,
            'grade'          => $profile->grade,
            'level'          => $profile->level_in_pay_matrix,
            'mobile_no'      => $profile->mobile_no,
            'email'          => $profile->email_id ?? $profile->email,
            'equivalent_rank'=> $profile->rank,
            'country'        => $countryname->name ?? null,
            'city'           => $firstLocation['city'] ?? null,
            'from_date'      => $firstLocation['meeting_from'] ?? null,
            'to_date'        => $firstLocation['meeting_to'] ?? null,
            'cadre'          => $profile->cadre,
            'rank'           => $profile->rank,
            'sector'         => $itusector->name ?? null,
        ];

        // ======================================
        //  🔥  Create Word Document
        // ======================================
        // dd(file_exists(storage_path('app/templates/sanction_template.docx')));

        $templatePath = storage_path('app/templates/sanction_template.docx');
        $template = new TemplateProcessor($templatePath);

        // Basic replacements
        $template->setValue('meeting_name', $data['meeting_name']);
        $template->setValue('city', $data['city']);
        $template->setValue('officername', $officerdd->officername);
        $template->setValue('designation', $officerdd->officername);
        $template->setValue('country', $data['country']);
        $template->setValue('from_date', $data['from_date']);
        $template->setValue('to_date', $data['to_date']);
        $template->setValue('sanction_date', now()->format('d F Y'));
        $template->setValue('finance_diary_number', '__________');


        // OFFICERS ARRAY
        //         $officersData = [];
        //         $sno = 1;

        //         foreach ($officers as $officer) {

        //             $profile = Profile::where('staff_no', $officer->staff_no)->first();
        //             if (!$profile) continue;

        //            $officersData[] = [
        //     'sno'         => $sno++,
        //     'name'        => $profile->officer_name,
        //     'designation' => $profile->designation,
        //     'rank'        => $profile->rank . ', ' . $profile->level_in_pay_matrix, // ✔ matches officers#rank
        //     'duration'    => $data['from_date'] . ' to ' . $data['to_date'],
        // ];
        //         }
        // // dd($template->getVariables());
        //         // Clone rows in the template
        //         $template->cloneRowAndSetValues('officersaa', $officersData);



        // Add more placeholders from template as needed...

        // ======================================
        //  🔥 Save Output Document
        // ======================================
        $fileName = 'sanction_' . Str::slug($qrp->meeting_name) . '_' . time() . '.docx';
        $outputPath = public_path('sanctions/' . $fileName);

        // Make directory if not exists
        if (!is_dir(public_path('sanctions'))) {
            mkdir(public_path('sanctions'), 0777, true);
        }

        $template->saveAs($outputPath);

        // Add file path into DB field
        $data['sanction_memo_doc'] = 'sanctions/' . $fileName;

        // Save final
        TourReport::create($data);

        $qrp->sanction_memo_doc = 'sanctions/' . $fileName;

        $qrp->save();

        $records[] = $data;
    }

    return redirect()->route('tourTracker.index')
        ->with('success', 'Sanction memo(s) generated successfully.');
}


}
