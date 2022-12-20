<?php

namespace App\Http\Controllers;

use App\Models\capacity;
use Illuminate\Http\Request;
use App\Models\location;



class CapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = location::all();



        return view('capacity.index')->with('locations',$locations);
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


        $capacity = new capacity();
        $days = explode(',',$request->days);
        \DB::table('capacities')->where('location_id',$request->location_id)->where('day',$days[1])->delete();
        $capacity->location_id = $request->location_id;
        $capacity->day_number = $days[0];
        $capacity->day = $days[1];
        $capacity->breakfast= $request->breakfast;
        $capacity->lunch = $request->lunch;
        $capacity->dinner = $request->dinner;

        $capacity->save();

        return redirect()->back()->with('success', 'Day was added!');
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



        $days = capacity::orderBy('day_number','ASC')->where('location_id',$id)->get();

        return view('capacity.edit')->with('location',$location)->with('days',$days);
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
        $capacity = capacity::find($id);
        $capacity->delete();

        return redirect()->back()->with('danger','Day was removed');
        //
    }
}
