<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Closedate;

class BlackoutExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $col = Closedate::all();
        return $col;
        //
    }

    public function headings(): array {

        return[
            'id','location_id','blackoutdate', 'created','updated'
        ];
    }
}
