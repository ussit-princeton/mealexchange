<?php

namespace App\Http\Controllers;

use App\Models\transaction;
use Illuminate\Http\Request;
use App\Models\location;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


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
        //cas user


        $transaction = transaction::where('host_userid',cas()->user())->where('id',$id)->first();


        if($transaction->status=='Pending') {

            return view('approvals.edit')->with('transaction',$transaction);
        }

        else if ($transaction->staus=='Approved') {
            return 'Reservation has been approved already';
        }

        else {
            abort(403);

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

        //temporary
        $host_userid = cas()->user();
        //check to see if the approver is host userid
        $transaction = transaction::where('id',$id)->where('host_userid',$host_userid)->where('status',"Pending")->first();


        $message = location::find($transaction->location_id);
        if($transaction) {
            $update = transaction::find($id)->update(['status'=>'Approved','comments'=>$request->comments]);

            \Mail::raw("$transaction->host_name has approved $transaction->guest_name at $transaction->location_name for $transaction->mealperiod on $transaction->meal_date. " 
                .PHP_EOL. $message->email_message
                , function($message) use($transaction)
            {
                $message->from('jk20@princeton.edu');
                $message->to([$transaction->host_userid."@princeton.edu", $transaction->guest_userid."@princeton.edu"]);
                $message->subject('Reservation Approved @ '.$transaction->location_name);
            });



            return 'Reservation for the guest has been approved';


        }

        else {

            return 'No reservations or reservation has already been approved';
        }




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
