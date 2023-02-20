<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\transaction;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, withHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return transaction::all();
        //
    }
    public function headings(): array {

        return[
            'id', 'puid', 'meal_date', 'week_no', 'location_id', 'location_name', 'mealperiod', 'meal_day',
            'host_userid', 'host_puid', 'host_name', 'guest_userid', 'guest_puid', 'guest_name', 'approved',
            'status', 'comments', 'processed', 'manual_entry', 'entry_userid', 'created_at', 'updated_at'
        ];
    }
}
