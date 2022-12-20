<?php

namespace App\Http\Controllers;

use App\Models\transaction;
use Illuminate\Http\Request;

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
        $cas_user = 'dspotto';


        $transaction = transaction::where('host_userid',$cas_user)->where('id',$id)->first();

        if($transaction) {

            return view('approvals.edit')->with('transaction',$transaction);
        }
        else {
            return 'No reservation to be approved';
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
        $host_userid = 'dspotto';
        //check to see if the approver is host userid
        $transaction = transaction::where('id',$id)->where('host_userid',$host_userid)->where('status',"Pending Host")->first();

        if($transaction) {
            $update = transaction::find($id)->update(['status'=>'Approved','comments'=>$request->comments]);
        }

        return 'Reservation for the guest has been approved';


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
