<?php

namespace App\Imports;

use App\Models\Meal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;


class MealImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        return new Meal([
            'puid'     => $row[3],
            'meal_remaining'    => $row[4],

        ]);
        // TODO: Implement model() method.
    }

    public function startRow(): int {
        return 2;
    }

}
