<?php

namespace App\Models;

use App\Models\transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class Exports implements FromCollection
{
    public function collection() {
        return transaction::where('processed',1)->pluck('meal_date','mealperiod','location_name','guest_puid','guest_name','location_name')->get();
    }

}
