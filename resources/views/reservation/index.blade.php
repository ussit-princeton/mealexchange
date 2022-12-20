@extends('layout')

@section('content')

<div class="row">

<div class="col-md-12 mb-5">

    <div class="card" >
        <h5 class="card-header bg-success">
            Locations
        </h5>
        <div class="card-body">

        <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Location Name</th>


    </tr>
  </thead>
  <tbody>


  @foreach($locations as $location)
    <tr>
      <th scope="row">{{$location->id}}</th>
      <td>{{$location->location_name}} <a href="reservation/{{$location->id}}/edit"><button class="btn btn-primary">Select</button></a>  </td>


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

