@extends('layout')

@section('content')


<div class="row">

<div class="col-md-12 mb-5">

    <div class="card" >
        <h5 class="card-header bg-success">
            Eating Clubs
        </h5>
        <div class="card-body">

        <table class="table table-bordered">
  <thead>
    <tr>

      <th scope="col">Location Name</th>
        <th>Information as of {{\Carbon\Carbon::now()->format('m/d/Y')}}</th>


    </tr>
  </thead>
  <tbody>


  @foreach($locations as $location)
    <tr>

      <td>{{$location->location_name}}
          @if(in_array($location->id, $closed))
              <span class="badge badge-danger">Closed today</span>
          @endif

          @if($location->openstatus==0)
              <span class="badge badge-danger">Unavailable at this time</span>
         @endif



      </td>

      <td>

          <a href="club/{{$location->id}}/edit">
              @if ($location->reservation == 1)
                <button class="btn btn-primary btn-sm">Reserve</button></a>

              @else
                <button class="btn btn-info btn-sm">Information or Availability</button></a>
              @endif
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


@endsection

