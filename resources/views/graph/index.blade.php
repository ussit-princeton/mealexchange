@extends('layout')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <div class="row">

        <div class="col-md-9">
            <canvas id="myChart" style="width:100%"></canvas>
        </div>
        <div class="col-md-3">
            <canvas id="myChart2" style="width:100%"></canvas>
        </div>


    </div>
    <div class="row" style="margin-top: 100px;">

        <h4>Total Transactions</h4>

        <button class="btn btn-primary" onclick="window.location.href='https://clubmeal.cpaneldev.princeton.edu/graphs/create';">
            Report

        </button>
        <div class="table-responsive">
            <table id="example" class="table table-sm" style="font-size:13px;">
                <thead>
                <tr>

                    <td>Date</td>
                    <td>Location</td>
                    <td>Guest</td>
                    <td>Host</td>
                    <td>Meal</td>
                    <td>Status</td>



                    <!--td>ICal</td -->

                </tr>

                </thead>

                <tbody>
                @foreach($total_transactions as $transaction)
                    <tr>
                        <td>{{$transaction->meal_date}}</td>
                        <td>{{$transaction->location_name}}</td>
                        <td>{{$transaction->guest_name}}</td>
                        <td>{{$transaction->host_name}}</td>
                        <td>{{$transaction->mealperiod}}</td>
                        <td>{{$transaction->status}}</td>


                    </tr>

                @endforeach



                </tbody>





            </table>


    </div>

    <script>

        new Chart("myChart", {
            type: "bar",
            data: {
                labels: {!! json_encode($clubs) !!},
                datasets: [
                    {backgroundColor: "green",
                        data:  {!! json_encode($breakfast) !!},
                        label: "Breakfast",
                        type: "bar",
                    },
                    {backgroundColor: "blue",
                        data:  {!! json_encode($lunch) !!},
                        label: "Lunch",
                        type: "bar",
                    },

                    {backgroundColor: "orange",
                        data:  {!! json_encode($dinner) !!},
                        label: "Dinner",
                        type: "bar",
                    }],
            },
            options: {
                title: {
                    display: true,
                    text: "Meals per Club/Co-op"
                },
                tooltips: {
                    displayColors: true,
                    callbacks: {
                        mode: 'x',
                    },
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                        },
                        type: 'linear',
                    }]
                },

            }
       });
    </script>

    <script>
        var xValues = ["Participant", "Non Participant"];
        var yValues = [{!! json_encode($participants) !!},300];
        var barColors = [
            "green",
            "red"

        ];

        new Chart("myChart2", {
            type: "pie",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "# of members who participated vs total pilot members"
                }
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                responsive:true
            });
        });
    </script>


@endsection
