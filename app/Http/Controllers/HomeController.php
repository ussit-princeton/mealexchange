<?php

namespace App\Http\Controllers;

use App\Models\transaction;
use Illuminate\Http\Request;
use App\Models\Meal;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->group == 'checker') {

            return redirect('/checkin/'.\Auth::user()->location_id);
        }

        $balance = 'No Meal Plan, contact dining.';

        $mealsforweek = Meal::where('puid', \Auth::user()->puid)->pluck('meal_remaining')->first();



        if($mealsforweek!=null) {
            $balance = $mealsforweek;
        }

        //cas Authentication to find current reservation
        $userid = \Auth::user()->userid;

        $current_week = \Carbon\Carbon::now()->weekOfYear;

        $transactions = transaction::orderBy('meal_date','ASC')->where('guest_userid',$userid)->where('week_no','<',$current_week)->with('meals')->get();
        $currentweek_transactions = transaction::orderBy('meal_date','ASC')->where('week_no',$current_week)->where('guest_userid',$userid)->with('meals')->get();
        $reservations = transaction::orderBy('meal_date','ASC')->where('guest_userid',$userid)->where('week_no','>',$current_week)->with('meals')->get();



        return view('index')->with('transactions',$transactions)->with('current_week',$current_week)->with('currentweek',$currentweek_transactions)->with('balance',$balance)->with('reservations', $reservations);




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
