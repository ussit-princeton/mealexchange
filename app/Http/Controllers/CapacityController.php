<?php

namespace App\Http\Controllers;

use App\Models\capacity;
use App\Models\Closedate;
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

        if(\Auth::user()->group=='admin') {

            $locations = location::all();

            return view('capacity.index')->with('locations',$locations);
        }
        else {

           $location = \Auth::user()->location_id;
           return $this->edit($location);
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



        if (\Auth::user()->group=='admin' or \Auth::user()->location_id==$request->location_id) {


            if(isset($request->description)) {


                $location = location::find($request->location_id);
                
                $location->description = $request->description;

                if(isset($request->email_message)) {
                    $location->email_message = $request->email_message;
                }

                $location->save();

                return redirect()->back()->with('success','Description and email confirmation was updated');

            }

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

        else {
            abort(404);
        }



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

        if (\Auth::user()->group=='admin' or \Auth::user()->location_id==$id) {

            $location = location::where('id',$id)->first();

            $blackoutdates = Closedate::where('location_id',$id)->get();


            $days = capacity::orderBy('day_number','ASC')->where('location_id',$id)->get();

            return view('capacity.edit')->with('location',$location)->with('days',$days)->with('blackoutdates', $blackoutdates);
        }

        else {
            return abort(403);
        }


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


        if ($capacity != null) {

            $location_id = $capacity->location_id;


            if (\Auth::user()->group=='admin' or \Auth::user()->location_id==$location_id) {

                $capacity = capacity::find($id);
                $capacity->delete();

                return redirect()->back()->with('danger', 'Day was removed');
                //
            }

            else {
                abort(403);
            }

        }
        else {

            return redirect()->back()->with('danger', 'Nothing to remove');
        }



    }
}
