@extends('layout')

@section ('content')


            <div class="row">

             <div class="col-md-12">

            <div class="card" >
                <h5 class="card-header bg-danger">
                  {{$location->location_name}} - Today's Meals
                </h5>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example1" class="table table-sm" style="font-size:13px;">
                            <thead>
                            <tr>

                                <td>Date</td>
                                <td>Guest</td>
                                <td>Host</td>
                                <td>Meal</td>
                                <td>Status</td>
                                <td>Week Balance</td>

                                <td>Delete</td>
                                <!--td>ICal</td -->

                            </tr>

                            </thead>

                            <tbody>
                            @foreach($today as $transaction)

                                <tr>
                                    <td>{{$transaction->meal_date}}</td>
                                    <td>{{$transaction->guest_name}}</td>
                                    <td>{{$transaction->host_name}}</td>
                                    <td>{{$transaction->mealperiod}}</td>
                                    <td>{{$transaction->status}}</td>
                                    <td>{{isset($transaction->meals->meal_remaining) ? $transaction->meals->meal_remaining : 'No Meal Plan'}}</td>
                                    @if(!$transaction->processed ==1)
                                    <td><form method="POST" action="/checkin/{{$transaction->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger show_confirm" style="font-size: 0.8em;">Delete</button>
                                        </form>
                                    </td>
                                    @endif

                                </tr>

                            @endforeach



                            </tbody>





                        </table>
                    </div>


                </div>
                <div class="card-footer">

                </div>
            </div>


                 <hr>



        </div>
    </div>


            <hr>

            <div class="row">


                <div class="col-md-12 mb-5">


                    <div class="card" >
                        <h5 class="card-header bg-success">
                             Today@ <span id='ct5' style=""></span>- <span id="meal_periods">{{$meal_period}}</span>
                        </h5>
                        <div class="card-body">

                            <form method="POST" action="/checkin">
                                @csrf

                                <input type="hidden" value="{{$location->id}}" name="location_id">
                                <input type="hidden" value="status" name="status">

                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="radio2" name="openstatus" value="1" {{$location->openstatus == 1 ? 'checked': ''}}>Open
                                <label class="form-check-label" for="radio2" style="margin-right: 20px"></label>
                                <input type="radio" class="form-check-input" id="radio1" name="openstatus" value="0" {{$location->openstatus==0 ? 'checked' : ''}}>Unavailable
                                <label class="form-check-label" for="radio1"></label>

                                <button class="btn btn-info">Update Status</button>
                            </div>
                            </form>
                            <hr>


                            <form method="POST" action="/checkin">
                                @csrf

                                <div class="form-check">

                                </div>



                                <input type="hidden" value="{{$location->location_name}}" name="location_name">
                                <input type="hidden" value="{{$location->id}}" name="location_id">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Guest Name (email address or userid)</label>
                                    <input type="text" required name="guest" class="form-control" id="exampleFormControlInput1" placeholder="xjk@princeton.edu or xjk">
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Host Name (email address or userid) {{$location->admin_user}} </label>
                                    <input type="text" required name="host" class="form-control" id="exampleFormControlInput1" placeholder="Enter host">
                                </div>


                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Meal Period</label>
                                    <select required class="form-control" id="exampleFormControlSelect1" name="mealperiod">
                                        <option {{$meal_period == 'Closed' ? 'selected': ''}}  value="">Pick one:</option>
                                        <option {{$meal_period == 'Breakfast' ? 'selected': ''}} value="breakfast">Breakfast</option>
                                        <option {{$meal_period == 'Lunch' ? 'selected': ''}}  value="lunch">Lunch</option>
                                        <option {{$meal_period == 'Dinner' ? 'selected': ''}}  value="dinner">Dinner</option>

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

            <script>

               function display_ct5() {
                    var x = new Date()
                    var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
                    var hour = x.getHours()
                    var placeholder = ''
                    if(x.getHours() >= 13) {
                        hour=hour- 12
                    }

                    if(x.getMinutes() < 10) {
                        placeholder = '0'
                    }

                    var meal_select = document.querySelector('#exampleFormControlSelect1')

                    var x1=x.getMonth() + 1+ "/" + x.getDate() + "/" + x.getFullYear();
                    x1 = x1 + " - " +  hour+ ":" + placeholder+ x.getMinutes() + ampm;
                    document.getElementById('ct5').innerHTML = x1;


                    if (x.getHours() < 11 && x.getHours() > 6) {
                        document.getElementById('meal_periods').innerHTML= 'Breakfast'
                        meal_select.value = 'breakfast'


                    }
                   if (x.getHours() > 10 && x.getHours() < 14) {
                       document.getElementById('meal_periods').innerHTML= 'Lunch'
                       meal_select.value = 'lunch'


                   }
                   if (x.getHours() > 15 && x.getHours() < 19) {
                       document.getElementById('meal_periods').innerHTML= 'Dinner'
                       meal_select.value = 'dinner'

                   }



                    display_c5();
                }
                function display_c5(){
                    var refresh=1000; // Refresh rate in milli seconds
                    mytime=setTimeout('display_ct5()',refresh)
                }

            </script>

            <script>

                $(document).ready(function () {
                    $('#example').DataTable({
                        responsive:true
                    });
                    display_c5()
                });
            </script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
            <script type="text/javascript">

                $('.show_confirm').click(function(event) {
                    var form =  $(this).closest("form");
                    var name = $(this).data("name");
                    event.preventDefault();
                    swal({
                        title: `Are you sure you want to delete this record?`,
                        text: "",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                form.submit();
                            }
                        });
                });

                $('.closedate').click(function(event) {
                    event.preventDefault();
                    var form = $(this).closest("form");
                    var name = $(this).data("name");

                    var closedate = $("input[name='openstatus']:checked").val();

                    if(closedate == 0) {
                        swal({
                            title: 'The current status is unavailable.  Do you want to continue?',
                            text: "",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                    form.submit();
                                }
                            });
                    }

                    else {
                        form.submit();
                    }

                })



            </script>



    @endsection
