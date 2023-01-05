@extends('layout')

@section ('content')

<div class="row">

<div class="col-md-12 mb-5">

    <div class="card" >
        <h5 class="card-header bg-success">
            Introduction
        </h5>
        <div class="card-body">

            <p class="card-text">
                Club meals are first come first basis. Reservations are needed for co-op's.



                <br>

            </p>
        </div>
        <div class="card-footer">
            <a href="/reservation"><button class="btn btn-primary">Reserve/Occupancy</button></a>


        </div>

    </div>

<hr>

    <div class="row">


        <div class="col-md-12">

            <div class="card" >
                <h5 class="card-header bg-danger">
                    Current Week Meals/Reservation
                </h5>
                <div class="card-body">
                    <p><b class="text-danger">*Meal Balance: 3</b></p>
                    <div class="table-responsive">
                        <table id="example" class="table table-sm" style="font-size:14px;">
                            <thead>
                            <tr>

                                <td>Date</td>
                                <td>Location</td>
                                <td>Meal</td>
                                <td>Host</td>
                                <td>Status</td>

                                <td>Delete</td>
                                <!--td>ICal</td -->

                            </tr>

                            </thead>

                            <tbody>
                            @foreach($currentweek as $transaction)
                                <tr>
                                    <td>{{$transaction->meal_date}}</td>
                                    <td>{{$transaction->location_name}}</td>
                                    <td>{{$transaction->mealperiod}}</td>
                                    <td>{{$transaction->host_name}}</td>
                                    <td>{{$transaction->status}}</td>

                                    <td>

                                        @if (\Carbon\Carbon::now()->format('Y-m-d') <= $transaction->meal_date and $transaction->status != 'Manual Insert')

                                        <form method="POST" action="/reservation/{{$transaction->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                            @endif

                                    </td>

                                </tr>

                            @endforeach



                            </tbody>





                        </table>
                    </div>


                </div>
                <div class="card-footer">
                    <p class="text-danger">*Meal Balance reflects past meals taken this week @Club/Co-ops and Dining Halls.</p>
                    <p class="text-danger">*Please Note: Meal balances should be equal to or greater than the number of reservations. If not, reservations will be removed automatically.</p>
                </div>
            </div>





        </div>





    </div>
    <hr>
    <div class="row">

<div class="col-md-12">

    <div class="card" >
        <h5 class="card-header bg-primary">
            Future and Past Meals
        </h5>
        <div class="card-body">

            <div class="table-responsive">
                <table id="example" class="table table-sm" style="font-size:14px;">
                    <thead>
                    <tr>

                        <td>Date</td>
                        <td>Location</td>
                        <td>Meal</td>
                        <td>Host</td>
                        <td>Status</td>

                        <td>Delete</td>
                        <!--td>ICal</td -->

                    </tr>

                    </thead>

                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->meal_date}}</td>
                            <td>{{$transaction->location_name}}</td>
                            <td>{{$transaction->mealperiod}}</td>
                            <td>{{$transaction->host_name}}</td>
                            <td>{{$transaction->status}}</td>

                            <td>
                                @if (\Carbon\Carbon::now()->format('Y-m-d') <= $transaction->meal_date)
                                <form method="POST" action="/reservation/{{$transaction->id}}">
                                    @csrf
                                    @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @endif

                            </td>

                        </tr>

                    @endforeach



                    </tbody>





                </table>
            </div>


        </div>
        <div class="card-footer">

        </div>
    </div>





</div>





</div>

<hr>
</div>




@endsection
