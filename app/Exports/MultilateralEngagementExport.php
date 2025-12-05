<?php

namespace App\Exports;

use App\Models\MultilateralEngagement;
use Maatwebsite\Excel\Concerns\FromCollection;

class MultilateralEngagementExport implements FromCollection
{
    public function collection()
    {
        return MultilateralEngagement::with('country')->get();
    }
}
