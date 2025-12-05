<?php

namespace App\Exports;

use App\Models\SanctionMemo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ForeignVisitExport implements FromCollection, WithHeadings
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function collection()
    {
        return SanctionMemo::select(
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
            ->whereYear('from_date', $this->year)
            ->orderBy('from_date', 'ASC')
            ->get();
    }

    public function headings(): array
    {
        return [
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
