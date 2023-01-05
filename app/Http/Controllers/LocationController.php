<?php

namespace App\Http\Controllers;

use App\Models\capacity;
use App\Models\Closedate;
use Illuminate\Http\Request;
use App\Models\location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $locations = location::all();
        return view('location.index')->with('locations',$locations);



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
        $blackout = Closedate::where('location_id',$id)->get();



        return view('location.edit')->with('location',$location)->with('blackouts',$blackout);


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

       $location = location::find($id);
       $location->min_date= $request->min_date;
       $location->max_date = $request->max_date;
       $location->reservation = $request->reservation;

       $location->save();

       return redirect()->back()->with('success', 'Date parameters were updated');

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
