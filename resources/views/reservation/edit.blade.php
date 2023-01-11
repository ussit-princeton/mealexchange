@extends('layout')


@section('content')


    <div class="row">

        <div class="col-md-12 mb-5">

            <div class="card" >
                <h5 class="card-header bg-success">
                   {{$location->location_name}}
                </h5>
                <div class="card-body">




                </div>
                <div class="card-footer">

                </div>
            </div>


        </div>
    </div>

    <div class="row">

        <div class="col-md-12 mb-5">

            <div class="card" >
                <h5 class="card-header bg-success">
                    Availability for the Week of {{\Carbon\Carbon::now()->startOfWeek()->format('m/d/Y')}}
                </h5>
                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                        <tr>

                            <th scope="col">Day</th>
                            <th scope="col">Breakfast</th>
                            <th scope="col">Lunch</th>
                            <th scope="col">Dinner</th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($occupancy as $occ)
                            <tr>
                                <td>{{$occ->day}}</td>
                                <td>{{$occ->breakfast}}</td>
                                <td>{{$occ->lunch}}</td>
                                <td>{{$occ->dinner}}</td>
                            </tr>
                        @endforeach



                        </tbody>
                    </table>




                </div>
                <div class="card-footer">

                </div>
            </div>


        </div>
    </div>


    <div class="row">

        <div class="col-md-12 mb-5">

            <div class="card" >
                <h5 class="card-header bg-success">
                    Blackout Dates
                </h5>
                <div class="card-body">

                    @foreach ($blackouts as $blackout)

                        <b class="badge badge-danger">{{$blackout->closedate}}</b>
                    @endforeach




                </div>
                <div class="card-footer">

                </div>
            </div>


        </div>
    </div>


<div class="row">
    @if ($location->reservation == 1)
<div class="col-md-12 mb-5">


    <div class="card" >
        <h5 class="card-header bg-success">
         <b>{{$location->location_name}}</b> -  Reservation/Information
        </h5>
        <div class="card-body">



        <form method="POST" action="{{ route('reservation.update',$location->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" value="{{$location->location_name}}" name="location_name">

  <div class="form-group">
      <label for="exampleFormControlInput1">Host Name (email address or userid)<br> <b class="text-danger">If not hosted please enter:  {{$location->admin_user}}</b></label>
    <input type="text" name="host" class="form-control" id="exampleFormControlInput1" placeholder="xjk@princeton.edu or xjk">
  </div>
  <div class="form-group">
  <p>Date: <input class="form-control" name="date" type="text" id="datepicker"data-date-start-date="{{$min_date}}" data-date-end-date="{{$max_date}}"></p>
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
    @endif


</div>
</div>

<script type="text/javascript">

 var array = {!! json_encode($inactive)  !!};

  var dateToday = new Date();
  $(function() {
    $( "#datepicker" ).datepicker({
        format: 'yyyy-mm-dd',
        minDate: dateToday,
        datesDisabled: array
    });
  } );

  </script>


@endsection
