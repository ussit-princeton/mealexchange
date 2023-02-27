<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\BlackoutExport;

class ExportBlackout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:blackout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return \Excel::store(new BlackoutExport,'reports/blackout.csv');
    }
}
