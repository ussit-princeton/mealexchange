@extends('layout')

@section ('content')



            <div class="row">

                <div class="col-md-12">

                    <div class="card" >
                        <h5 class="card-header bg-primary">
                           Meal History - {{$location->location_name}}
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


            <script>

                $(document).ready(function () {
                    $('#example').DataTable({
                        responsive:true
                    });
                });
            </script>


    @endsection
