<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourReport;
use App\Models\QrpForm;
use App\Models\QrpOfficer;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
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
    // 1️⃣ Get the QRP form
    $qrp = QrpForm::findOrFail($id);

    // 2️⃣ Get related officers
    $officers = QrpOfficer::where('qrp_id', $qrp->id)->get();

    // 3️⃣ Iterate through officers and map full data
    $records = [];

    foreach ($officers as $officer) {
        // Find matching profile (based on staff_no)
        $profile = Profile::where('staff_no', $officer->staff_no)->first();

        if (!$profile) {
            continue; // skip if no profile found
        }

        // Find associated user
        $user = User::find($profile->user_id);

        // Extract first country and city from JSON (assuming $qrp->country is JSON array)
        $firstLocation = null;
        if (!empty($qrp->country)) {
            $locations = json_decode($qrp->country, true);
            if (is_array($locations) && count($locations) > 0) {
                $firstLocation = $locations[0];
            }
        }

        // Build data array
        $data = [
            'tour_id'        => $qrp->meeting_id,
            'user_id'        => $user ? $user->id : null,
            'staff_number'   => $officer->staff_no,
            'meeting_name'   => $qrp->meeting_name,
            'purpose'        => $qrp->justification,
            'service'        => $profile->service,
            'title'          => $profile->title,
            'name'           => $profile->officer_name,
            'date_of_birth'  => $profile->date_of_birth,
            'gender'         => $profile->gender,
            'designation'    => $profile->designation,
            'grade'          => $profile->grade,
            'level'          => $profile->level,
            'mobile_no'      => $profile->mobile_no,
            'email'          => $profile->email_id ?? $profile->email,
            'equivalent_rank'=> $profile->equivalent_rank,
            'country'        => $firstLocation['country'] ?? null,
            'city'           => $firstLocation['city'] ?? null,
            'from_date'      => $firstLocation['meeting_from'] ?? null,
            'to_date'        => $firstLocation['meeting_to'] ?? null,
            'cadre'          => $profile->cadre,
            'rank'           => $profile->rank,
            'sector'         => $profile->sector,
        ];

        // 4️⃣ You can either store or collect the record
        // Example: Save to your `sanction_memos` table
        TourReport::create($data);

        // Or store temporarily in array
        $records[] = $data;
    }

    // 5️⃣ Return success or view
    return response()->json([
        'status' => 'success',
        'message' => 'Sanction memo data generated successfully.',
        'data' => $records
    ]);
}

}
