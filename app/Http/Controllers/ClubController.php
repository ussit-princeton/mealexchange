<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\capacity;
use App\Models\Closedate;
use App\Models\location;
use App\Models\transaction;
use App\Models\User;
use http\Params;
use App\Models\host;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $currentday = \Carbon\Carbon::now()->format('l');
        $currentweekno = \Carbon\Carbon::now()->weekOfYear;



        $locations = location::where('reservation',0)->with('capacity')->orderBy('location_name','asc')->get();



        foreach($locations as $location) {

            foreach ($location->capacity as $cap) {

                $breakfastcount = transaction::where('week_no',$currentweekno)->where('location_id',$location->id)->where('meal_day',$currentday)->where('mealperiod','breakfast')->count();
                $lunchcount = transaction::where('week_no',$currentweekno)->where('location_id',$location->id)->where('meal_day',$currentday)->where('mealperiod','lunch')->count();
                $dinnercount = transaction::where('week_no',$currentweekno)->where('location_id',$location->id)->where('meal_day',$currentday)->where('mealperiod','dinner')->count();

                if ($cap->day == $currentday) {
                    $cap->breakfast -= $breakfastcount;
                    $cap->lunch -= $lunchcount;
                    $cap->dinner -= $dinnercount;
                }
             

            }
        }


        $now = \Carbon\Carbon::now()->format('Y-m-d');

        $closed = Closedate::where('closedate',$now)->pluck('location_id')->toArray();




        return view('club.index')->with('locations',$locations)->with('closed',$closed)->with('currentday',$currentday);
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
        //
    }
}
