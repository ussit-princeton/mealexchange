<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\transaction;
use App\Exports\TransactionExport;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $transactions = \DB::table('transactions')->distinct()->get(['location_name']);

        $details = transaction::all();

        foreach($transactions as $transaction) {
            $transaction->breakfast = 0;
            $transaction->lunch = 0;
            $transaction->dinner =0;

            foreach ($details as $detail) {

                if ($transaction->location_name == $detail->location_name) {
                    if ($detail->mealperiod == 'breakfast') {
                        $transaction->breakfast +=1;
                    }
                    if ($detail->mealperiod == 'lunch') {
                        $transaction->lunch +=1;
                    }
                    if ($detail->mealperiod == 'dinner') {
                        $transaction->dinner +=1;
                    }
                }
            }

        }

        $breakfast = [];
        $lunch = [];
        $dinner = [];
        $clubs = [];


        foreach ($transactions as $transaction) {
            array_push($clubs, $transaction->location_name);
            array_push($breakfast, $transaction->breakfast);
            array_push($lunch, $transaction->lunch);
            array_push($dinner, $transaction->dinner);

        }

        $total_transactions = transaction::all();


        return view('graph.index')->with('clubs',$clubs)->with('breakfast',$breakfast)->with('lunch',$lunch)->with('dinner',$dinner)->with('total_transactions',$total_transactions);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return \Excel::download(new TransactionExport, 'invoices.xlsx');
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
