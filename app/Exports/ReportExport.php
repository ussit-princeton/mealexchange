<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\transaction;

class ReportExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return transaction::all();
        //
    }
}
