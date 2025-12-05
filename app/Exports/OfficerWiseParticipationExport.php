<?php

namespace App\Exports;

use App\Models\SanctionMemo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OfficerWiseParticipationExport implements FromCollection, WithHeadings
{
    protected $officer;

    public function __construct($officer)
    {
        $this->officer = $officer;
    }

    public function collection()
    {
        return SanctionMemo::select(
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
            ->where('name', $this->officer)
            ->orderBy('from_date', 'ASC')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Year',
            'Meeting Name',
            'Purpose',
            'Title',
            'Name',
            'Date of Birth',
            'Gender',
            'Country',
            'City',
            'From Date',
            'To Date',
        ];
    }
}
