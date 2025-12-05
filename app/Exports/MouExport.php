<?php
namespace App\Exports;

use App\Models\Mou;
use Maatwebsite\Excel\Concerns\FromCollection;

class MouExport implements FromCollection
{
    public function collection()
    {
        return Mou::with('country')->get();
    }
}
