<?php

namespace App\Imports;

use App\Models\Meal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class MealImport implements ToModel
{
    public function model(array $row)
    {
        return new Meal([
            'puid'     => $row[0],
            'meal_remaining'    => $row[1],

        ]);
        // TODO: Implement model() method.
    }

}
