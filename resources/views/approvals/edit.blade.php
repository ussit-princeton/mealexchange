@extends('layout')

@section('content')






<div class="row">

<div class="col-md-12 mb-5">

    <div class="card" >
        <h5 class="card-header bg-success">
            Approve Meal for Guest
        </h5>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><b>Guest: {{$transaction->guest_name}}</b> </li>
                <li class="list-group-item"><b>Host: {{$transaction->host_name}}</b> </li>
                <li class="list-group-item"><b>Date: {{$transaction->meal_date}}</b></li>
                <li class="list-group-item"><b>Location: {{$transaction->location_name }}</b></li>
                <li class="list-group-item"><b>Meal Period: {{$transaction->mealperiod }}</b></li>


            </ul>

            <hr>



<form method="POST" action="/approval/{{$transaction->id}}">
    @csrf
    @method('PATCH')

  <div class="form-group">
      <input type="hidden" value="{{$transaction->id}}" name="id">
    <label for="exampleFormControlTextarea1">Comments</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comments"></textarea>
  </div>
  <div class="form-group">

  <button class="btn btn-primary">Approve</button>

  </div>
</form>




        </div>
        <div class="card-footer">

        </div>
    </div>


</div>
</div>



@endsection
