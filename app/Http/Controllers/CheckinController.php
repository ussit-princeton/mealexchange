<?php

namespace App\Http\Controllers;

use App\Models\host;
use App\Models\User;
use http\Message;
use http\Params;
use Illuminate\Http\Request;
use App\Models\location;
use App\Models\transaction;
use App\Models\capacity;
use App\Models\Meal;


class CheckinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(\Auth::user()->group == 'admin') {

            $locations = location::all();

            return view('checkin.index')->with('locations',$locations);

        }
        else {

            return $this->show(\Auth::user()->location_id);
        }

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
        if(\Auth::user()->group=='admin' or \Auth::user()->location_id == $request->location_id) {


            if(isset($request->openstatus)) {

                $location = location::find($request->location_id);

                $location->openstatus = $request->openstatus;
                $location->save();

                return redirect()->back()->with('success', 'Current status is updated');

            }

            $hostname = $request->host;
            $guestname = $request->guest;
            $club_name = $request->location_name;

            #check host belonging to the club
            $host = host::where(function ($query) use ($hostname) {
                return $query->where('userid', '=', $hostname)
                    ->orWhere('email', '=', $hostname);
            })->where(function ($query) use ($club_name) {
                return $query->where('clubname', '=', $club_name);
            })->first();


            #check guest is allowed to be entered
            $guest = User::where(function ($query) use ($guestname) {
                return $query->where('userid', '=', $guestname)
                    ->orWhere('email', '=', $guestname);
            })->first();



            //check dates are within range

            //Error Checking
            if ($guest == null) {
                return redirect()->back()->with('danger', "No guest $guestname was found for $club_name");
            }
            if ($host == null) {
                return redirect()->back()->with('danger', "No host $hostname was found for $club_name");
            }
            if ($guest->userid == $host->userid) {
                return redirect()->back()->with('danger', "Guest and Host can not be the same");
            }
            //no duplicate meals
            $request_date= \Carbon\Carbon::parse($request->date)->format('Y-m-d');
            $duplicate = transaction::where("meal_date",$request_date)->where("mealperiod",$request->mealperiod)->where("guest_userid","=",$guest->userid)->count();

            if($duplicate > 0) {
                return redirect()->back()->with('danger', "Guest already has checked in for $request->mealperiod" );

            }

            //check if guest is part of the same club
            $checkguest = host::where('userid',$guest->userid)->where('location_id',$request->location_id)->count();

            if ($checkguest > 0) {
                return redirect()->back()->with('danger', $guest->userid. " is already in $club_name");
            }




            //no meals past 8:00pm or before 7am
            $end = '20:00:00';
            $start = '06:00:00';
            $now = \Carbon\Carbon::now()->format('H:i:s');


            if($now > $end || $now < $start) {
                return redirect()->back()->with('danger', 'Check in is not available at this time');

            }

            //check if user has enough meals
            $noOfMeals = Meal::where('puid',$guest->puid)->pluck('meal_remaining')->first();
            if($noOfMeals < 0 || $noOfMeals==null) {
                return redirect()->back()->with('danger', 'Guest has used all meals for the week or is not on a meal plan, remaining: '.$noOfMeals);
            }







            //no more than capacity
        //  $mealperiod = $request->mealperiod;
         /*   $week_no = \Carbon\Carbon::now()->weekOfYear;
            $currentday = \Carbon\Carbon::parse($request->date)->format('l');

            $transactionsforweek = transaction::where('week_no',$week_no)->where('location_id',$request->location_id)->where('meal_day',$currentday)->where('mealperiod',$mealperiod)->count();

            $cap = capacity::where('location_id',$request->location_id)->where('day',$currentday)->first(); */

            /*make sure the meals checked in is the correct meal period


            /*      if($cap) {
                if($mealperiod =='breakfast') {

                    if($transactionsforweek > $cap->breakfast)

                    return redirect()->back()->with('danger', "Meal period is filled");
                }
                if($mealperiod =='lunch') {
                    if($transactionsforweek > $cap->lunch)

                    return redirect()->back()->with('danger', "Meal period is filled");
                }
                if($mealperiod =='dinner') {

                    if($transactionsforweek > $cap->lunch)

                    return redirect()->back()->with('danger', "Meal period is filled");
                }

            } */






            $transaction = new transaction();
            $transaction->puid = $guest->puid;
            $transaction->meal_date = $request_date;
            $transaction->week_no = \Carbon\Carbon::parse($request->date)->weekOfYear;
            $transaction->location_id = $request->location_id;
            $transaction->location_name = $request->location_name;
            $transaction->mealperiod = $request->mealperiod;
            $transaction->meal_day = \Carbon\Carbon::parse($request->date)->format('l');
            $transaction->host_userid = $host->userid;
            $transaction->host_puid = $host->puid;
            $transaction->host_name = $host->name;
            $transaction->guest_userid = $guest->userid;
            $transaction->guest_puid = $guest->puid;
            $transaction->guest_name = $guest->name;
            $transaction->approved = 1;
            $transaction->status = 'Checkin';
            $transaction->entry_userid = \Auth::user()->userid;
            




            \Mail::raw("$transaction->guest_name has checked in with $transaction->host_name at $transaction->location_name for $transaction->mealperiod on $transaction->meal_date.", function($message) use($transaction)
            {
                $message->from('jk20@princeton.edu');
                $message->to([$transaction->guest_userid."@princeton.edu", $transaction->host_userid."@princeton.edu"]);
                $message->subject('Club Checkin @ '.$transaction->location_name);
            });


            $transaction->save();



            return redirect()->back()->with('success', 'Transaction was added');
        }

        else {

            abort(403);
        }
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
        if(\Auth::user()->group=='admin' or \Auth::user()->location_id == $id) {

            $current_week = \Carbon\Carbon::now()->weekOfYear;

            $location = location::where('id', $id)->first();

            $today = \Carbon\Carbon::now()->format('Y-m-d');

            $meal_period = '';

            //get current meal period
            $now = \Carbon\Carbon::now();

            //breakfast start
            $breakfast_start = \Carbon\Carbon::createFromTimeString('06:00');
            $breakfast_end = \Carbon\Carbon::createFromTimeString('11:00');

            //lunch start
            $lunch_start = \Carbon\Carbon::createFromTimeString('11:01');
            $lunch_end = \Carbon\Carbon::createFromTimeString('14:00');

            //dinner_start
            $dinner_start = \Carbon\Carbon::createFromTimeString('14:01');
            $dinner_end = \Carbon\Carbon::createFromTimeString('20:01');

            if($now->between($breakfast_start, $breakfast_end, true)) {
                $meal_period = 'Breakfast';
            }
            else if($now->between($lunch_start, $lunch_end, true)) {
                $meal_period = 'Lunch';
            }
            else if($now->between($dinner_start, $dinner_end, true)) {
                $meal_period = 'Dinner';
            }
            else {
                $meal_period = 'Closed';
            }


            $today_transaction = transaction::where('meal_date', $today)->where('location_id', $id)->with('meals')->get(
            );

            $transactions = transaction::orderBy('id', 'DESC')->where('location_id', $id)->with('meals')->get();



            $meals_remaining = Meal::where('puid',\Auth::user()->puid)->first();

            return view('checkin.show')->with('transactions', $transactions)->with('current_week', $current_week)->with(
                'location',
                $location
            )->with('today', $today_transaction)->with('meal_period',$meal_period);
            //
        }
        else {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


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

       $transaction=  transaction::find($id);
       $transaction->status= 'Approved';
       $transaction->entry_userid = \Auth::user()->userid;
       $transaction->save();

       $location = location::find($transaction->location_id);

        \Mail::raw("Dear $transaction->guest_name ".\Auth::user()->name. " has approved your meal with $transaction->host_name at $transaction->location_name for $transaction->mealperiod on $transaction->meal_date.".PHP_EOL. $location->email_message , function($message) use($transaction)
        {
            $message->from('jk20@princeton.edu');
            $message->to([$transaction->guest_userid."@princeton.edu", $transaction->host_userid."@princeton.edu"]);
            $message->subject('Club Checkin @ '.$transaction->location_name);
        });

       return redirect()->back()->with('success', 'Reservation has been approved');
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
        $transaction = transaction::find($id);

        if(\Auth::user()->group=='admin' or \Auth::user()->location_id==$transaction->location_id) {

            //cant delete processed lunches
            if ($transaction->processed == 1) {
                return redirect()->back()->with('danger', 'Items already processed, can not be deleted');
            }

            $transaction = transaction::find($id)->delete();

            return redirect()->back()->with('danger', 'Item has been deleted successfully');

        }

        else {
            abort(403);
        }


        //
    }
}
