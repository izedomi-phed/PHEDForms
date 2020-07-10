<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PHED FORMS</title>

            <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script src="{{ asset('assets/js/core.min.js') }}"></script>
        <script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/thesaas.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
     

    <!-- Header -->
    <header class="header header-inverse h-fullscreen bg-primary">
        <canvas class="constellation"></canvas>
      <div class="header-overlay opacity-90" style="backgrond-color:#000"></div>
     
       

      <div class="container text-center">

        <div class="row h-full justify-content-center">
          <div class="card card-shadowed col-12 col-md-6 py-4 align-self-center bg-white text-dark elevation-3 rounded">
            <br>
            <div class="text-center">
                <a href='.'><img src="{{asset('images/PHEDLogo.jpg')}}" alt="phed logo"  style="width:100px;height:100px"/></a>
            <div>

            <h1 class="display-5 text-primary">STAFF FORMS PORTAL</h1>
            <small> Available Forms: DLEnhance Access, Sage Access, VPN(Non-staff), Wifi(Non-staff) </small>
           
            <hr class="w-50">

            <p>
              <a class="btn btn-lg btn-round btn-outline btn-primary w-250 mb-2" href="{{route('login')}}">Staff Login</a>
              
              <a class="btn btn-lg btn-round btn-outline btn-primary w-250 mb-2" href="{{route('register')}}">Create Account</a>
             
            </p>
   
          </div>
        </div>

      </div>
    </header>
    <!-- END Header -->


   
    </body>
</html>
