@extends('layout')

@section('content')


<div class="row">

<div class="col-md-12 mb-5">

    <div class="card" >
        <h5 class="card-header bg-success">
            Eating Clubs- Today {{\Carbon\Carbon::now()->format('m/d/Y')}}
        </h5>
        <div class="card-body">

        <table class="table table-bordered">
  <thead>
    <tr>

      <th scope="col">Location Name</th>
        <th>Club Information</th>


    </tr>
  </thead>
  <tbody>


  @foreach($locations as $location)
    <tr>

      <td>{{$location->location_name}}
          @if(in_array($location->id, $closed))
              <span class="badge badge-danger">Closed today</span>
          @endif

          @if($location->openstatus==0 and !in_array($location->id,$closed))
              <span class="badge badge-danger">Unavailable at this time</span>
         @endif

          @if(count($location->capacity) > 0 )
              @php
                  $location->done = 2;
              @endphp
          @foreach($location->capacity as $capacity)


              @if($capacity->day == $currentday and $location->openstatus!=0 and !in_array($location->id, $closed))

                  @php
                    $location->done = 1;
                  @endphp
                      @if($capacity->breakfast > 0 )
                          <span class="badge badge-success">Breakfast</span>

                      @endif

                      @if($capacity->lunch > 0 )
                          <span class="badge badge-success">Lunch</span>


                      @endif

                      @if($capacity->dinner > 0 )
                          <span class="badge badge-success">Dinner</span>

                      @endif

                      @if ($capacity->breakfast <=0 and $capacity->lunch <=0 and $capacity->dinner <=0)
                              <span class="badge badge-danger">No Open Slots</span>
                      @endif

                  @endif


              @endforeach


          @else

              @if ($location->openstatus!=0 and !in_array($location->id, $closed) )
              <span class="badge badge-success">Breakfast</span>
              <span class="badge badge-success">Lunch</span>
              <span class="badge badge-success">Dinner</span>

              @endif

          @endif

          @if($location->done == 2 and $location->openstatus!=0 and !in_array($location->id, $closed))
              <span class="badge badge-success">Breakfast</span>
              <span class="badge badge-success">Lunch</span>
              <span class="badge badge-success">Dinner</span>

          @endif

      </td>

      <td>



          <a href="club/{{$location->id}}/edit">
              @if ($location->reservation == 1)
                <button class="btn btn-primary btn-sm">Reserve</button></a>

              @else
                <button class="btn btn-info btn-sm" style="font-size: 12px;">Info & Availability</button></a>
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

