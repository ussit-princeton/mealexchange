<?php

namespace App\Http\Controllers;

use App\Models\capacity;
use App\Models\Closedate;
use App\Models\location;
use App\Models\transaction;
use App\Models\User;
use http\Params;
use Illuminate\Http\Request;
use App\Models\host;



class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = location::where('reservation',1)->orderBy('location_name','asc')->get();
        $now = \Carbon\Carbon::now()->format('Y-m-d');

        $closed = Closedate::where('closedate',$now)->pluck('location_id')->toArray();


        return view('reservation.index')->with('locations',$locations)->with('closed',$closed);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $location = location::where('id',$id)->first();

        if(!$location) {
            abort(404);
        }

        //get count of meals today
        $week_no = \Carbon\Carbon::now()->weekOfYear;
        $transactionsforweek = transaction::where('week_no',$week_no)->where('location_id',$id)->get();

        $occupancy = capacity::orderBy('day_number','ASC')->where('location_id',$location->id)->get();

        foreach($occupancy as $cap) {

            foreach($transactionsforweek as $transaction) {

                if ($transaction->meal_day == $cap->day) {
                    if($transaction->mealperiod =='breakfast')
                        $cap->breakfast--;
                    if($transaction->mealperiod =='lunch')
                        $cap->lunch--;
                    if($transaction->mealperiod =='dinner')
                        $cap->dinner--;

                }
            }
        }

        $blackout = Closedate::where('location_id', $id)->get();
        $inactive = Closedate::where('location_id',$id)->pluck('closedate')->toArray();





        $min_date = "+".$location->min_date."d";
        $max_date = "+".$location->max_date."d";

        return view('reservation.edit')->with('location',$location)->with('max_date',$max_date)->with('min_date',$min_date)->with('occupancy',$occupancy)->with('blackouts',$blackout)->with('inactive',$inactive);

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $hostname = $request->host;
        $club_name = $request->location_name;
        $user_id = \Auth::user()->userid;

        #check host belonging to the club
        $host = host::where(function ($query) use ($hostname,$id) {
            return $query->where('userid', '=', $hostname)
                ->orWhere('email', '=', $hostname);
        })->where(function ($query) use ($club_name,$id) {
            return $query->where('location_id', '=', $id);
        })->first();

        //replace userid with cas authentication get current user
        $guest = User::where('userid',$user_id)->first();


        //making sure they dont have 5 meals in a week


        //some validation
        //check host name
        if ($host==null) {
            return redirect()->back()->with('danger', "No host $hostname was found for $club_name");
        }

        if ($host->userid == \Auth::user()->userid) {
            return redirect()->back()->with('danger', "Guest and Host can not be the same");
        }

        //no duplicates
        $request_date= \Carbon\Carbon::parse($request->date)->format('Y-m-d');
        $duplicate = transaction::where("meal_date",$request_date)->where("mealperiod",$request->mealperiod)->where("guest_userid","=",$guest->userid)->count();

        if($duplicate > 0) {
            return redirect()->back()->with('danger', 'No duplicate meals allowed');
        }

        //no more than capacity
        $mealperiod = $request->mealperiod;
        $week_no = \Carbon\Carbon::parse($request->date)->weekOfYear;
        
        $currentday = \Carbon\Carbon::parse($request->date)->format('l');

        $transactionsforweek = transaction::where('week_no',$week_no)->where('location_id',$id)->where('meal_day',$currentday)->where('mealperiod',$mealperiod)->count();

        $cap = capacity::where('location_id',$id)->where('day',$currentday)->first();

        if($cap) {
            if($mealperiod =='breakfast') {

                if($transactionsforweek >= $cap->breakfast)

                return redirect()->back()->with('danger', "Meal period is not available");
            }
            if($mealperiod =='lunch') {
               if($transactionsforweek >= $cap->lunch)

                return redirect()->back()->with('danger', "Meal period is not available");
            }
            if($mealperiod =='dinner') {
                if($transactionsforweek >= $cap->dinner)

                return redirect()->back()->with('danger', "Meal period is not available");
            }

        }

        //check dates are within range and include blackout dates
        $alloweddates = location::find($id);
        $startdate = \Carbon\Carbon::now()->addDays($alloweddates->min_date -1);
        $endate = \Carbon\Carbon::now()->addDays($alloweddates->max_date +1);
        $blackoutdates = Closedate::where('location_id', $id)->get();
        $min_date = $alloweddates->min_date;




        //between the min and max date
        if (!\Carbon\Carbon::parse($request->date)->between($startdate, $endate)) {

            return redirect()->back()->with('danger','Please make sure the date is within range.');
        }



        foreach($blackoutdates as $blackout) {
            if (\Carbon\Carbon::parse($request_date) == \Carbon\Carbon::parse($blackout->closedate)) {
                return redirect()->back()->with('danger', 'Club is closed for guests during this time.');
            }
        }

        //makes sure they dont have more than 5 reservations in a week
        $week_no = \Carbon\Carbon::parse($request->date)->weekOfYear;
        $transaction_week = transaction::where('week_no',$week_no)->where('guest_userid',\Auth::user()->userid)->count();
        if ($transaction_week >5) {
            return redirect()->back()->with('danger', 'You are only allowed to have 5 meals per week reserved.');
        }

        //make sure they are a guest in the same club they belong to
        $hostperson = host::where('userid', \Auth::user()->userid)->where('clubname',$club_name)->count();
        if($hostperson > 0) {
            return redirect()->back()->with('danger', ' You can not reserve a club that you already belong to');
        }




        $transaction = new transaction();
        $transaction->puid = $guest->puid;
        $transaction->meal_date = \Carbon\Carbon::parse($request->date);
        $transaction->week_no = $week_no;
        $transaction->location_id = $id;
        $transaction->location_name = $request->location_name;
        $transaction->mealperiod = $request->mealperiod;
        $transaction->meal_day = $currentday;
        $transaction->host_userid = $host->userid;
        $transaction->host_puid = $host->puid;
        $transaction->host_name = $host->name;
        $transaction->guest_userid = $guest->userid;
        $transaction->guest_puid = $guest->puid;
        $transaction->guest_name = $guest->name;
        $transaction->approved = 0;
        $transaction->status = 'Pending';

       $transaction->save();




        //email host
        \Mail::raw("$transaction->guest_name has requested for approval to $transaction->host_name at $transaction->location_name for $transaction->mealperiod on ". substr($transaction->meal_date,0,10)."."
        .PHP_EOL."Please click on the link https://diningpilotapp.princeton.edu/approval/$transaction->id/edit for approval. You have until " . \Carbon\Carbon::parse($transaction->meal_date)->subDays($min_date)->format('Y-m-d'). " to approve or the reservation will be removed.", function($message) use($transaction)
        {
            $message->from('clubmeal@princeton.edu');
            $message->to($transaction->host_userid."@princeton.edu");
            $message->subject('Reservation approval @ '.$transaction->location_name);
        });

        $location = location::find($transaction->location_id);

        //email checkers of the location
      $admin_users = User::where('location_id',$transaction->location_id)->whereIn('group',['checker','both'])->pluck('email')->toArray();

        if(!count($admin_users) ==0 ) {
            \Mail::raw("$transaction->guest_name has requested $transaction->mealperiod on ". substr($transaction->meal_date,0,10).".", function($message) use($transaction,$admin_users)
            {
                $message->from('clubmeal@princeton.edu');
                $message->to($admin_users);
                $message->subject('Reservation request @ '.$transaction->location_name);
            });

        }



        //email guest
        if($location->email_message != null) {
            \Mail::raw("Your reservation has been sent to $transaction->host_name to dine at $transaction->location_name for $transaction->mealperiod on ". substr($transaction->meal_date,0,10)."."
                .PHP_EOL.PHP_EOL, function($message) use($transaction)
            {
                $message->from('clubmeal@princeton.edu');
                $message->to($transaction->guest_userid."@princeton.edu");
                $message->subject('Reservation Pending @ '.$transaction->location_name);
            });

        }


        return redirect('/')->with('success','Your reservation has been requested');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //replace with cas
        $guest_id= \Auth::user()->userid;

        $location_id = transaction::where('id',$id)->pluck('location_id')->first();

        $daystodelete = location::where('id',$location_id)->first();

        $now= \Carbon\Carbon::now();

        if (isset($daystodelete->min_date)) {

            $transaction = transaction::find($id);

            $dayOfReservation = \Carbon\Carbon::parse($transaction->meal_date)->subDays($daystodelete->min_date-1);

            if( $now > $dayOfReservation) {

                return redirect()->back()->with('danger', "Last day to delete this meal this meal was $dayOfReservation.");
            }

        }

        $transaction = transaction::where('guest_userid',$guest_id)->where('id',$id)->where('status','!=','Checkin')->first();


        \Mail::raw("$transaction->guest_name has cancelled the reservation with $transaction->host_name at $transaction->location_name for $transaction->mealperiod on $transaction->meal_date.", function($message) use($transaction)
        {
            $message->from('clubmeal@princeton.edu');
            $message->to([$transaction->host_userid."@princeton.edu", $transaction->guest_userid."@princeton.edu"]);
            $message->subject('Reservation Cancelled @ '.$transaction->location_name);
        });


         $transaction = transaction::where('guest_userid',$guest_id)->where('id',$id)->where('status','!=','Checkin')->delete();

        return redirect()->back()->with('danger','Transaction has been removed');


        //
    }
}
