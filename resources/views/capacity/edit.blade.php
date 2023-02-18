@extends('layout')

@section('content')

    <div class="row">

        <div class="col-sm-12 sm-5">

            <div class="card">
                <h5 class="card-header bg-success">
                    {{$location->location_name}} Description
                </h5>
                <form method="POST" action="/capacity">
                    @csrf
                    <input hidden name="location_id" value="{{$location->id}}">
                <div class="card-body">

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Intro Description</label>
                        <textarea style="white-space: pre-wrap;" class="form-control" id="exampleFormControlTextarea1" name="description" rows="6">{{$location->description}}</textarea>
                    </div>

                    @if ($location->reservation ==1)
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Additional Email Confirmation (Already included in email - the guest name and Host location/date/ and dining period.)</label>
                        <textarea style="white-space: pre-wrap;" class="form-control" id="exampleFormControlTextarea1" name="email_message" rows="6">{{$location->email_message}}</textarea>
                    </div>
                   @endif


                </div>
                <div class="card-footer">

                    <button class="btn btn-primary">Update</button>

                </div>
                </form>
            </div>


        </div>
    </div>


<hr>



<div class="row">

    <div class="col-sm-12 sm-5">

        <div class="card">
            <h5 class="card-header bg-success">
                {{$location->location_name}}- Add Days/Occupancy
            </h5>
            <div class="card-body">
                <table class="table table-bordered table-sm" style="font-size:12px;">
                    <thead>
                    <tr>

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

                <hr>

                <h4>Add Occupancy Limit</h4>

                <form method="POST" action="/capacity" >
                    @csrf

                    <input type="hidden" name="location_id" value={{$location->id}}>
                    <div class="form-group" id="Weekly" >

                        <div class="row">

                            <div class="col-3">

                                <div class="form-group">


                                    <label for="exampleFormControlSelect1" style="font-size: small">Select Day</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="days" >
                                        <option value="1,Monday">Monday</option>
                                        <option value="2,Tuesday">Tuesday</option>
                                        <option value="3,Wednesday">Wednesday</option>
                                        <option value="4,Thursday">Thursday</option>
                                        <option value="5,Friday">Friday</option>
                                        <option value="6,Saturday">Saturday</option>
                                        <option value="7,Sunday">Sunday</option>
                                    </select>

                                </div>
                            </div>


                            <div class="col-3">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" style="font-size: small" >Breakfast (Max Occupancy)</label>
                                    <input name="breakfast" type="number" class="form-control" id="exampleFormControlInput1" required>
                                </div>

                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" style="font-size: small">Lunch (Max Occupancy)</label>
                                    <input name="lunch" type="number" class="form-control" id="exampleFormControlInput1" required>
                                </div>


                            </div>


                            <div class="col-3">

                                <div class="form-group">
                                    <label for="exampleFormControlInput1" style="font-size: small">Dinner (Max Occupancy)</label>
                                    <input name="dinner" type="number" class="form-control" id="exampleFormControlInput1" required>
                                </div>


                            </div>


                            </div>








                    </div>



                    <div class="form-group">

                        <button class="btn btn-primary">Add</button>

                    </div>
                </form>




            </div>
            <div class="card-footer">

            </div>
        </div>


    </div>
</div>
    <hr>



<div class="row">

    <div class="col-sm-12 sm-5">


        <div class="card">
            <h5 class="card-header bg-success">
                {{$location->location_name}}- Blackout Dates
            </h5>
            <div class="card-body">
                <table class="table table-bordered table-sm" style="font-size:12px;">
                    <thead>
                    <tr>

                        <th>Day</th>
                        <th>Action</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blackoutdates as $day)
                        <tr>


                            <td>{{$day->closedate}}</td>

                            <td>
                                <form method="POST" action="{{route('blackout.destroy', $day->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" style="font-size:10px;">Delete</button>
                                </form>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>
                </table>

                <hr>
                <h4>Add Blackout Dates</h4>

                <form method="POST" action="/blackout">
                    @csrf

                   <div class="form-group" >
                       <input name="location_id" hidden value={{$location->id}}>
                       <label for="exampleFormControlInput1">Date:</label>
                       <input id="Blackout" name="blackoutdate"  class="form-control datepicker" id="datepicker" data-date-format="yyyy-mm-dd" required>


                   </div>




                    <div class="form-group">

                        <button class="btn btn-primary">Add</button>

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
    $(".datepicker").datepicker();
  });
</script>


@endsection
