<?php

namespace App\Http\Controllers;

use App\Models\capacity;
use App\Models\Closedate;
use App\Models\location;
use App\Models\transaction;
use App\Models\User;
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
        $locations = location::all();

        return view('reservation.index')->with('locations',$locations);
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
        $week_no = \Carbon\Carbon::now()->weekOfYear;
        $currentday = \Carbon\Carbon::parse($request->date)->format('l');

        $transactionsforweek = transaction::where('week_no',$week_no)->where('location_id',$id)->where('meal_day',$currentday)->where('mealperiod',$mealperiod)->count();

        $cap = capacity::where('location_id',$id)->where('day',$currentday)->first();

        if($cap) {
            if($mealperiod =='breakfast') {

                if($transactionsforweek >= $cap->breakfast)

                return redirect()->back()->with('danger', "Meal period is filled");
            }
            if($mealperiod =='lunch') {
               if($transactionsforweek >= $cap->lunch)

                return redirect()->back()->with('danger', "Meal period is filled");
            }
            if($mealperiod =='dinner') {
                if($transactionsforweek >= $cap->dinner)

                return redirect()->back()->with('danger', "Meal period is filled");
            }

        }

        //check dates are within range and include blackout dates
        $alloweddates = location::find($id);
        $startdate = \Carbon\Carbon::now()->addDays($alloweddates->min_date);
        $endate = \Carbon\Carbon::now()->addDays($alloweddates->max_date);
        $blackoutdates = Closedate::where('location_id', $id)->get();


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

        $transaction = new transaction();
        $transaction->puid = $guest->puid;
        $transaction->meal_date = \Carbon\Carbon::parse($request->date);
        $transaction->week_no = \Carbon\Carbon::parse($request->date)->weekOfYear;
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
        $transaction->status = 'Pending Host';

        $transaction->save();

        return redirect('/')->with('success','Your reservation has be inserted');






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

        $transaction = transaction::where('guest_userid',$guest_id)->where('id',$id)->delete();

        return redirect()->back()->with('danger','Transaction has been removed');


        //
    }
}
