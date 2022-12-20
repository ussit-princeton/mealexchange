@extends('layout')

@section('content')
<div class="row">

  <div class="col-sm-12 sm-5">

    <div class="card">
      <h5 class="card-header bg-success">
        {{$location->location_name}} - Max Occupancy
      </h5>
      <div class="card-body">

        <table class="table table-bordered table-sm" style="font-size:12px;">
          <thead>
            <tr>
              <th>id</th>
              <th>Day</th>
              <th>Breakfast</th>
              <th>Lunch</th>
              <th>Dinner</th>
              <th></th>

            </tr>
          </thead>
          <tbody>
            @foreach($days as $day)
            <tr>

              <td>{{$day->id}}</td>
              <td>{{$day->day}}</td>
              <td>{{$day->breakfast}}</td>
              <td>{{$day->lunch}}</td>
              <td>{{$day->dinner}}</td>
              <td>
                  <form method="POST" action="{{route('capacity.destroy', $day->id)}}">
                   @csrf
                   @method('DELETE')
                  <button class="btn btn-danger btn-sm" style="font-size:12px;">Delete</button>
                  </form>

              </td>

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

  <div class="col-sm-12 sm-5">

    <div class="card">
      <h5 class="card-header bg-success">
        {{$location->location_name}}- Add Days/Occupancy
      </h5>
      <div class="card-body">

        <form method="POST" action="/capacity">
          @csrf

          <input type="hidden" name="location_id" value={{$location->id}}>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Select Day</label>
            <select class="form-control" id="exampleFormControlSelect1" name="days">
              <option value="1,Monday">Monday</option>
              <option value="2,Tuesday">Tuesday</option>
              <option value="3,Wednesday">Wednesday</option>
              <option value="4,Thursday">Thursday</option>
              <option value="5,Friday">Friday</option>
              <option value="6,Saturday">Saturday</option>
              <option value="7,Sunday">Sunday</option>
            </select>
          </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Breakfast (Max Occupancy)</label>
                <input name="breakfast" type="number" class="form-control" id="exampleFormControlInput1" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Lunch (Max Occupancy)</label>
                <input name="lunch" type="number" class="form-control" id="exampleFormControlInput1" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Dinner (Max Occupancy)</label>
                <input name="dinner" type="number" class="form-control" id="exampleFormControlInput1" required>
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
  $(function() {
    $("#datepicker").datepicker();
  });
</script>


@endsection
