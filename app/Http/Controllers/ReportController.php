<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\location;
use App\Models\transaction;

class ReportController extends Controller
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

            return view('reports.index')->with('locations',$locations);

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

            return view('reports.show')->with('transactions', $transactions)->with('current_week', $current_week)->with(
                'location',
                $location
            )->with('today', $today_transaction);
            //
        }
        else {
            abort(403);
        }
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
