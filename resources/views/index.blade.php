@extends('layout')

@section ('content')

<div class="row">

<div class="col-md-12 mb-5">

    <div class="card" >
        <h5 class="card-header bg-success">
            {{\Auth::user()->name}}
        </h5>
        <div class="card-body">

            <p class="card-text">
                Club meals are first come first basis. Reservations are needed for co-op's.



                <br>

            </p>
        </div>
        <div class="card-footer">
            <a href="/club"><button class="btn btn-primary">Club Info</button></a>

            <span style="margin-left: 10px"><a href="/reservation"><button class="btn btn-primary">Co-op Reservations</button></a></span>


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
                    <p>*Meal Balance:<b class="text-danger"><u> {{$balance}}</u></b></p>
                    <div class="table-responsive">


                        @if (sizeof($currentweek) > 0)
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

                                        @if (\Carbon\Carbon::now()->format('Y-m-d') <= $transaction->meal_date and $transaction->status != 'Checkin')

                                        <form method="POST" action="/reservation/{{$transaction->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger show_confirm">Delete</button>
                                        </form>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach



                            </tbody>





                        </table>
                            @endif
                    </div>


                </div>
                <div class="card-footer">
                    <p class="text-danger">*Meal Balance reflects past meals taken this week @Club/Co-ops and Dining Halls.</p>
           
                </div>
            </div>





        </div>





    </div>
    <hr>

    <div class="row">

        <div class="col-md-12">

            <div class="card" >
                <h5 class="card-header bg-primary">
                    Co-op Reservations
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
                            @foreach($reservations as $transaction)
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
                                                <button class="btn btn-sm btn-danger show_confirm">Delete</button>
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

<div class="col-md-12">

    <div class="card" >
        <h5 class="card-header bg-info">
            Past Meals
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


</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">

        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Are you sure you want to delete this record?`,
                text: "Warning: New Reservations will be need to be approved by host again.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });

    </script>


@endsection
