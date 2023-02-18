<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\transaction;

class TransactionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $col = transaction::where('processed',1)->select('meal_date','location_name','guest_puid','guest_name','mealperiod')->get();

        return $col;


        //
    }
}
