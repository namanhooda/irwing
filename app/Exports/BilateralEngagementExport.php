<?php

namespace App\Exports;

use App\Models\BilateralEngagement;
use Maatwebsite\Excel\Concerns\FromCollection;

class BilateralEngagementExport implements FromCollection
{
    public function collection()
    {
        return BilateralEngagement::with('country')->get();
    }
}
