
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/thesaas.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
           @if($status == "RELIEF_OFFICER")
            <div class="content">
                <div class="title m-b-md text-primary">
                    PHED LEAVE REQUEST
                    <p> You are receiving this mail as the RELIEF OFFICER with regards to the leave request initiated by {{$staff_name}} with staff ID {{$staff_id}}</p>
                    <p> As the RELIEF OFFICER during the period of the leave, you are required to acknowledge the request</p>
                    <p> Please login into your account to complete the acknowledgement process</p>
                    <p> Thanks </p><br/><br/><br/>

                     <a href="{{ config('app.url') }}">Login into your account here</a>

                     <br/><br/>
                     <p> PLEASE NOTE: Login credentials is same as your bill verification credentials </p>

                    <p>Regards</p>
                    <p>HCM, PHED </p>

                </div>

            </div>
            @endif

            @if($status == "SUPERVISOR")
             <div class="content">
                 <div class="title m-b-md text-primary">
                     PHED LEAVE REQUEST
                     <p> You are receiving this mail as the SUPERVISOR with regards to the leave request initiated by {{$staff_name}} with staff ID {{$staff_id}}</p>
                     <p> As the SUPERVISOR, you are required to recommend the request</p>
                     <p> Please login into your account to complete the recommendation process</p>
                     <p> Thanks </p><br/><br/><br/>

                      <a href="{{ config('app.url') }}">Login into your account here</a>

                      <br/><br/>
                      <p> PLEASE NOTE: Login credentials is same as your bill verification credentials </p>

                     <p>Regards</p>
                     <p>HCM, PHED </p>

                 </div>

             </div>
             @endif

             @if($status == "OVERALL_SUPERVISOR")
              <div class="content">
                  <div class="title m-b-md text-primary">
                      PHED LEAVE REQUEST
                      <p> You are receiving this mail as the OVERALL SUPERVISOR with regards to the leave request initiated by {{$staff_name}} with staff ID {{$staff_id}}</p>
                      <p> As the OVERALL SUPERVISOR, you are required to recommend the leave request</p>
                      <p> Please login into your account to complete the recommendation process</p>
                      <p> Thanks </p><br/><br/><br/>

                       <a href="{{ config('app.url') }}">Login into your account here</a>

                       <br/><br/>
                       <p> PLEASE NOTE: Login credentials is same as your bill verification credentials </p>

                      <p>Regards</p>
                      <p>HCM, PHED </p>

                  </div>

              </div>
              @endif

        </div>

    <script src="{{ asset('assets/js/core.min.j') }}s"></script>
    <script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

</html>
