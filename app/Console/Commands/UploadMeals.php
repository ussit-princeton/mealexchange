<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\transaction;

class UploadMeals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:meals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export to csgold';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $uploadfile = '';

        $now = \Carbon\Carbon::now()->format('Y-m-d');


        $transactions = transaction::where('processed','=',null)->where('approved',1)->where('meal_date',$now)->get();

        if($transactions->count() > 0) {
            foreach($transactions as $transaction) {

                $uploadfile .= "T".",".$transaction->puid.","."17".","."--1".PHP_EOL;
                $trans = transaction::find($transaction->id);
                $trans->processed = 1;
                $trans->save();

           }
            \Storage::put('/download/ClubMeal.mp', $uploadfile);

        }

    }
}
