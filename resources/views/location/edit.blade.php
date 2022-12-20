@extends('layout')

@section('content')

<div class="row">

<div class="col-md-12 mb-5">

    <div class="card" >
        <h5 class="card-header bg-success">
         <b>{{$location->location_name}}</b> -  Start and End Reservation
        </h5>
        <div class="card-body">

  <form method="POST" action="{{ route('locations.update',$location->id) }}">
    @csrf
    @method('PATCH')

  <div class="form-group">
    <label for="exampleFormControlInput1">Reservation Start Day</label>
    <input type="number" name="min_date" class="form-control" id="exampleFormControlInput1" value="{{$location->min_date}}">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">Reservation End Day</label>
    <input type="number" name="max_date" class="form-control" id="exampleFormControlInput1" value="{{$location->max_date}}">
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
<script type="text/javascript">

  var dateToday = new Date();
  $(function() {
    $( "#datepicker" ).datepicker({
      minDate: dateToday
    });
  } );

  </script>


@endsection
