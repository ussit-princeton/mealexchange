<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\capacity;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScheduleExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $col = capacity::all();

        return $col;

        //
    }

    public function headings(): array {

        return[
            'id', 'location_id','breakfast','lunch','dinner','day_number','day','created','updated'
        ];
    }

}
