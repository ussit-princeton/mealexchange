<?php

namespace App\Http\Controllers;

use App\Models\host;
use App\Models\User;
use http\Params;
use Illuminate\Http\Request;
use App\Models\location;
use App\Models\transaction;


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
                return redirect()->back()->with('danger', 'No duplicate meals allowed');

            }







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
            $transaction->status = 'Manual Insert';
            $transaction->entry_userid = \Auth::user()->userid;

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

            $today_transaction = transaction::where('meal_date', $today)->where('location_id', $id)->with('meals')->get(
            );

            $transactions = transaction::orderBy('id', 'DESC')->where('location_id', $id)->with('meals')->get();

            return view('checkin.show')->with('transactions', $transactions)->with('current_week', $current_week)->with(
                'location',
                $location
            )->with('today', $today_transaction);
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
        $location_id = transaction::find($id)->location_id;

        if(\Auth::user()->group=='admin' or \Auth::user()->location_id==$location_id) {
            $transaction = transaction::find($id)->delete();

            return redirect()->back()->with('danger', 'Item has been deleted successfully');

        }

        else {
            abort(403);
        }


        //
    }
}
