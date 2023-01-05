@extends('layout')

@section('content')

<div class="row">

<div class="col-md-12 mb-5">

    <div class="card" >
        <h5 class="card-header bg-success">
            Eating Clubs and Co-ops
        </h5>
        <div class="card-body">

        <table class="table table-bordered">
  <thead>
    <tr>

      <th scope="col">Location Name</th>
        <th>Information</th>


    </tr>
  </thead>
  <tbody>


  @foreach($locations as $location)
    <tr>

      <td>{{$location->location_name}}
              @if ($location->reservation == 1)
                  <h6><span class="badge badge-success">Reservation Required</span></h6>

              @else
                  <h6><span class="badge badge-info">First Come First Serve</span></h6>
              @endif
              </td>

      <td>

          <a href="reservation/{{$location->id}}/edit">
              @if ($location->reservation == 1)
              <button class="btn btn-primary btn-sm">Reserve</button></a>
             @else
              <button class="btn btn-info btn-sm">Availability</button></a>
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

