<?php

namespace App\Exports;

use App\Models\CountryMissionMastersheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CountryMissionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return CountryMissionMastersheet::with('country')->get()->map(function ($item) {
            return [
                'Country' => $item->country->country_name,
                'India Offerings' => $item->india_key_offerings,
                'Country Asks' => $item->country_asks,
                'Engagement Status' => $item->engagement_status,
                'Last Meeting Date' => $item->last_meeting_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Country',
            'India Key Offerings',
            'Country Asks',
            'Engagement Status',
            'Last Meeting Date',
        ];
    }
}
