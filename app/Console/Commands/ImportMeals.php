<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Imports\MealImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportMeals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:meals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import meal plans from excel';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \DB::table('meals')->truncate();

        Excel::import(new MealImport, storage_path('app/meals.csv'));

    }
}
