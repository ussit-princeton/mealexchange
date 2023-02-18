@extends('layout')


@section('content')


    <div class="row">

        <div class="col-md-12 mb-5">

            <div class="card" >
                <h5 class="card-header bg-success">
                   {{$location->location_name}}
                </h5>
                <div class="card-body">

                    <p>{{$location->description}}</p>




                </div>
                <div class="card-footer">

                </div>
            </div>


        </div>
    </div>

    @if($occupancy->count() > 0 and $location->reservation == 1)
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

    @endif


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


        <div class="col-md-12 mb-5">


            <div class="card" >
                <h5 class="card-header bg-success">
                    Self Check in Request for {{\Carbon\Carbon::now()->format('m/d/Y')}}<span id='ct5' style=""></span>
                </h5>
                <div class="card-body">
                    <p>Please put in a request for today. The host and admin will receive an email for approval. (ALL REQUESTS ARE PENDING UNTIL APPROVED)</p>
                    <p>Once you have been approved by the host or admin, you will receive confirmation that your request has been approved.
                        You can also see this on your home landing page. <b>You will not be allowed to dine until your host or admin has approved your request.</b>
                    <b>All pending requests that are not approved will be deleted at end of day.</b></p>


                    <form method="POST" action="/club">
                        @csrf

                        <div class="form-check">

                        </div>



                        <input type="hidden" value="{{$location->location_name}}" name="location_name">
                        <input type="hidden" value="{{$location->id}}" name="location_id">


                        <div class="form-group">
                            <label for="exampleFormControlInput1">Host NetID</label>
                            <input type="text" required name="host" class="form-control" id="exampleFormControlInput1" placeholder="Enter host">
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Meal Period</label>
                            <select required class="form-control" id="exampleFormControlSelect2" name="mealperiod">
                                <option  value="">Pick one:</option>
                                <option  value="breakfast">Breakfast</option>
                                <option  value="lunch">Lunch</option>
                                <option  value="dinner">Dinner</option>

                            </select>
                        </div>

                        <div class="form-group">

                            <button class="btn btn-primary closedate">Submit</button>

                        </div>
                    </form>




                </div>
                <div class="card-footer">

                </div>
            </div>


        </div>
    </div>






</div>
</div>

<script type="text/javascript">

 var array = {!! json_encode($inactive)  !!};

  var dateToday = new Date();
  $(function() {
    $( "#datepicker" ).datepicker({
        format: 'yyyy-mm-dd',
        minDate: dateToday,
        datesDisabled: array,


    });
  } );

  </script>
  <script>
      var leadtime = {!! $location->min_date !!}

      $(function() {
          $("#datepicker").datepicker().on('changeDate', function(e) {
              let newwdate = new Date($(this).val());
              newwdate.setDate(newwdate.getDate() - leadtime)

              $("#deadline").text("The host has until "+ newwdate.toDateString() + " to approve, or the reservation will be deleted.")
              console.log(newwdate.toDateString())

          })
      })

  </script>


@endsection
