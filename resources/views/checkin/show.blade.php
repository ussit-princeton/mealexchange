@extends('layout')

@section ('content')


            <div class="row">

             <div class="col-md-12">

            <div class="card" >
                <h5 class="card-header bg-danger">
                    Today's Reservation
                </h5>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example1" class="table table-sm" style="font-size:13px;">
                            <thead>
                            <tr>

                                <td>Date</td>
                                <td>Guest</td>
                                <td>Host</td>
                                <td>Meal</td>
                                <td>Status</td>
                                <td>Week Balance</td>

                                <td>Delete</td>
                                <!--td>ICal</td -->

                            </tr>

                            </thead>

                            <tbody>
                            @foreach($today as $transaction)
                                <tr>
                                    <td>{{$transaction->meal_date}}</td>
                                    <td>{{$transaction->guest_name}}</td>
                                    <td>{{$transaction->host_name}}</td>
                                    <td>{{$transaction->mealperiod}}</td>
                                    <td>{{$transaction->status}}</td>
                                    <td>1</td>

                                    <td><form method="POST" action="/checkin/{{$transaction->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" style="font-size: 0.8em;">Delete</button>
                                        </form>
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


                 <hr>



        </div>
    </div>
            <div class="row">

                <div class="col-md-12">

                    <div class="card" >
                        <h5 class="card-header bg-primary">
                            Past and Future Reservations - {{$location->location_name}}
                        </h5>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="example" class="table table-sm" style="font-size:13px;">
                                    <thead>
                                    <tr>

                                        <td>Date</td>
                                        <td>Guest</td>
                                        <td>Host</td>
                                        <td>Meal</td>
                                        <td>Status</td>


                                        <td>Delete</td>
                                        <!--td>ICal</td -->

                                    </tr>

                                    </thead>

                                    <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{$transaction->meal_date}}</td>
                                            <td>{{$transaction->guest_name}}</td>
                                            <td>{{$transaction->host_name}}</td>
                                            <td>{{$transaction->mealperiod}}</td>
                                            <td>{{$transaction->status}}</td>


                                            <td>
                                                @if (\Carbon\Carbon::now()->format('Y-m-d') <= $transaction->meal_date)
                                                <form method="POST" action="/checkin/{{$transaction->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                <button class="btn btn-sm btn-danger" style="font-size: 0.8em;">Delete</button>
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

            <div class="row">


                <div class="col-md-12 mb-5">


                    <div class="card" >
                        <h5 class="card-header bg-success">
                            Manual Entry for Today-  {{Carbon\Carbon::today()->format('M d Y')}}
                        </h5>
                        <div class="card-body">



                            <form method="POST" action="/checkin">
                                @csrf
                                <input type="hidden" value="{{$location->location_name}}" name="location_name">
                                <input type="hidden" value="{{$location->id}}" name="location_id">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Guest Name (email address or userid)</label>
                                    <input type="text" required name="guest" class="form-control" id="exampleFormControlInput1" placeholder="xjk@princeton.edu or xjk">
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Host Name (email address or userid)</label>
                                    <input type="text" required name="host" class="form-control" id="exampleFormControlInput1" placeholder="xjk@princeton.edu or xjk">
                                </div>


                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Meal Period</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="mealperiod">
                                        <option value="breakfast">Breakfast</option>
                                        <option value="lunch">Lunch</option>
                                        <option value="dinner">Dinner</option>

                                    </select>
                                </div>

                                <div class="form-group">

                                    <button class="btn btn-primary">Submit</button>

                                </div>
                            </form>




                        </div>
                        <div class="card-footer">

                        </div>
                    </div>


                </div>
            </div>
            <script>

                $(document).ready(function () {
                    $('#example').DataTable({
                        responsive:true
                    });
                });
            </script>


    @endsection
