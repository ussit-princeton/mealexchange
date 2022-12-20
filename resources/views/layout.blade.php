<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Meal Reservations</title>


    <!-- Bootstrap core CSS -->

    <link href="https://lunchtogo.deptcpanel.princeton.edu/styles/bootstrap.min.css"  rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://lunchtogo.deptcpanel.princeton.edu/styles/carousel.css" rel="stylesheet">
    <link href="https://lunchtogo.deptcpanel.princeton.edu/styles/bootstrap-datepicker.standalone.css" rel="stylesheet">
    <link href="https://lunchtogo.deptcpanel.princeton.edu/styles/jquery.timepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="https://lunchtogo.deptcpanel.princeton.edu/styles/bootstrap-select.css">
    <link rel="stylesheet" href="https://lunchtogo.deptcpanel.princeton.edu/styles/jquery.dataTables.min.css">
    <!-- link rel="stylesheet" href="//asset('styles/jquery.datatable-responsive.min.css'" -->


    <style>
        *{
            padding: 0;
            margin: 0;
        }

        .card-header {

            color:white;
        }

        .navbar {

            border-top-color: #E77500;
            border-top-style: solid;
            border-top-width: 4px;
            height: 120px;
            padding-left: 30px;
            font-weight: bold;
        }

        .navbar-collapse {

            background-color: #f8f9fa;
        }

        .navbar-nav {

            margin-left: 10px;

        }
        .list-inline{display:block;}
        .list-inline li{display:inline-block;}
        .list-inline li:after{content:'|'; margin:0 10px;}


        html {
            position: relative;
            min-height: 100%;
        }

        body {

            margin-bottom:0px;
            padding-bottom: 0px;
        }

        legend.group-border {
            width: inherit;
            /* Or auto */
            padding: 0 10px;
            /* To give a bit of padding on the left and right */
            border-bottom: none;
        }
        fieldset.group-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }



        body{
            display:block;
        }

        label {

            padding-right: 5px;
            padding-left: 5px;
        }

        .btn {
            margin-left: 5px;
        }

        .footer {


            margin-top:100px;
            bottom:0;
            background-color: #333333;
            border-top: 5px solid #e77500;
            color: white;
            font-size: 0.875em;
            height: 100%;
            padding-top: 50px;

        }

        .footer a:link, .footer a:visited {
            color: white;
        }

        .nav-item {

            font-size: 16px;
        }

        ul {
            list-style-type: none;
        }



        .small-option {
            font-size: 14px;
            padding: 5px;
            background: #5c5c5c;
        }

        .selcls {
            padding: 9px;
            border: solid 1px #517B97;
            outline: 0;
            background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF));
            background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px);
            box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;
            -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;
            -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;
            font-size: 13px;

        }

        #myCarousel {
            height: auto;
            width: auto;
            overflow: hidden;
        }
        .carousel-caption {
            width:200px;
            z-index:10;
            color:#fff;
            text-align:center;
            top:50%;
            left:10%;
            bottom:auto;
            -webkit-transform:translate(0, -50%);
            -ms-transform:translate(0, -50%);
            transform:translate(0, -50%);
        }





    </style>
    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>




</head>
<body>

<header>
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
        <a class="navbar-brand" href="https://dining.princeton.edu">
            <img alt="Campus Dining logo"  height="40px" src="{{url('/images/dining_logo.png')}}" class="img-responsive">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav">


                <li class="nav-item">
                    <a class="nav-link null" href="/">Home</a>
                </li>


                    <li class="nav-item">

                        <a class="nav-link "  href="/reservation">Reservations</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="/locations">Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/capacity">Occupancy</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link " href="/checkin">Checkin</a>
                    </li>
                   <li class="nav-item">
                       <div class="nav-link primary"><h6><span class="badge badge-secondary">Logged in as: James Kim</span></h6></div>
                   </li>




            </ul>

        </div>
    </nav>
</header>

<main role="main">

    <div id="myCarousel" class="carousel slide" style="height: 400px" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel"  data-slide-to="0" class="active"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="first-slide" src="{{url('/images/eatingclubs2.jpg')}}" style="height: 400px" alt="First slide">
                <div class="container">

                </div>
            </div>
        </div>

    </div>

    <div class="container">

    @if(!empty($errors->first()))
            <div class="row col-lg-12">
                <div class="alert alert-danger">
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('danger'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <div class="container">


        </div>

        @yield('content')






    </div>




</main>
<div class="footer" style="height: 100%">

    <div class="container" >
        <div class="row">


            <div class="col-md-4">
                <p>Campus Dining - University Services<br>
                    Phone: 609-258-6097<br>

                    <a href="mailto:dining@princeton.edu">dining@princeton.edu</a></p>

                <p>Princeton Catering and Paper Tiger<br>
                    609-258-3726
                    <br>
                    <a href="mailto:catering@princeton.edu">catering@princeton.edu</a><br>
                    <a href="mailto:ptiger@princeton.edu">ptiger@princeton.edu</a></p>

                <p><a href="http://www.princeton.edu/universityservices/"><img alt="University Services" src="https://lunchtogo.deptcpanel.princeton.edu/img/us_logo.png"></a></p>


            </div>
            <div class="col-md-4">


                <ul class="links inline clearfix">
                    <li class="menu-10021 first"><a href="https://menus.princeton.edu/dining/_Foodpro/online-menu/">Today's Menus</a></li>

                    <li class="menu-11206"><a href="https://dining.princeton.edu/meal-plans">Meal Plans</a>
                    </li>
                    <li class="menu-9891"><a href="https://dining.princeton.edu/hours-operation">Hours of Operation</a></li>
                    <li class="menu-10036"><a href="https://dining.princeton.edu/catering/reunions">Reunions Planning</a></li>
                    <li class="menu-9886 last"><a href="https://dining.princeton.edu/our-story/join-our-team">Careers</a></li>

                </ul>
            </div>
            <div class="col-md-4">
                <p><a href="http://www.princeton.edu/" title="Princeton University"><img src="https://lunchtogo.deptcpanel.princeton.edu/img/pu-logo-white.svg" alt="Princeton University Logo"></a></p>
            </div>
        </div>
    </div>
</div>


</body>
</html>
