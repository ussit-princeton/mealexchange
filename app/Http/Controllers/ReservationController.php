<?php

namespace App\Http\Controllers;

use App\Models\capacity;
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

        $occupancy = capacity::orderBy('day_number','ASC')->where('location_id',$location->id)->get();




        $min_date = "+".$location->min_date."d";
        $max_date = "+".$location->max_date."d";

        return view('reservation.edit')->with('location',$location)->with('max_date',$max_date)->with('min_date',$min_date)->with('occupancy',$occupancy);

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

       // dd($request);
        $hostname = $request->host;
        $club_name = $request->location_name;
        $user_id = 'jk20';

        #check host belonging to the club
        $host = host::where(function ($query) use ($hostname) {
            return $query->where('userid', '=', $hostname)
                ->orWhere('email', '=', $hostname);
        })->where(function ($query) use ($club_name) {
            return $query->where('clubname', '=', $club_name);
        })->first();

        //replace userid with cas authentication get current user
        $guest = User::where('userid',$user_id)->first();


        //check host name
        if ($host==null) {
            return redirect()->back()->with('danger', "No host $hostname was found for $club_name");
        }

        //check dates are within range

        //makes sure they dont have more than 5 reservations in a week

        $transaction = new transaction();
        $transaction->puid = $guest->puid;
        $transaction->meal_date = \Carbon\Carbon::parse($request->date);
        $transaction->week_no = \Carbon\Carbon::parse($request->date)->weekOfYear;
        $transaction->location_id = $id;
        $transaction->location_name = $request->location_name;
        $transaction->mealperiod = $request->mealperiod;
        $transaction->meal_day = \Carbon\Carbon::parse($request->date)->format('l');
        $transaction->host_userid = $host->userid;
        $transaction->host_name = $host->name;
        $transaction->guest_userid = $guest->userid;
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
        $guest_id= 'jk20';

        $transaction = transaction::where('guest_userid',$guest_id)->where('id',$id)->delete();

        return redirect()->back()->with('danger','Transaction has been removed');


        //
    }
}
