<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\transaction;

use App\Models\location;

class DeleteUnapproved extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:unapproved';

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
        $locations = location::where('reservation',1)->get();
        $today = \Carbon\Carbon::now()->addDays(5)->toDateString();





        foreach($locations as $location) {

            $transaction = transaction::where('location_id', $location->id)->where('status','Pending')->get();


            if($transaction->count()) {

                foreach($transaction as $trans) {


                    if(\Carbon\Carbon::createFromFormat('Y-m-d',$trans->meal_date)->subDays($location->min_date) < \Carbon\Carbon::now()->format('Y-m-d')) {


                        \Mail::raw("$trans->guest_name, your reservation with $trans->host_name at $trans->location_name for $trans->mealperiod on $trans->meal_date."
                      .PHP_EOL."Reservation was to be approved by " . \Carbon\Carbon::createFromFormat('Y-m-d',$trans->meal_date)->subDays($location->min_date)->toDateString()."." ." Please contact the club administrator if you need any additional information.", function($message) use($trans)
                          {
                              $message->from('jk20@princeton.edu');
                              $message->to([$trans->host_userid."@princeton.edu", $trans->guest_userid."@princeton.edu"]);
                              $message->bcc('jk20@princeton.edu');
                              $message->subject('Reservation cancelled @ '.$trans->location_name);
                          });


                        transaction::find($trans->id)->delete();


                    }



                }



            }

        }
    }
}
