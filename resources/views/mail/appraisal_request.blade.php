
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
           @if($res == "appraiser")
            <div class="content">
                <div class="title m-b-md text-primary">
                    PHED APPRAISAL
                    <p> You are receiving this mail with regards to the ongoing PHED employee appraisal </p>
                    <p> You are requested as an APPRAISER to appraise the given employee whose link is included below</p>
                    <p> Thanks </p><br/><br/><br/>

                     <a href="{{ config('app.url') }}/appraiser/employee/{{$id}}/{{$staff_id}}">click here for employee appraisal form</a>

                    <p>Regards</p>
                    <p>HCM, PHED </p>

                </div>
               
            </div>
            @endif
            @if($res == "employee")
                <div class="content">
                    <div class="title m-b-md text-primary">
                        PHED APPRAISAL
                        <p> Your appraisal review is completed.</p>
                    </div>
                </div>

            @endif
            @if($res == "reviewer")
            <div class="content">
                <div class="title m-b-md text-primary">
                    PHED APPRAISAL
                     <p> You are receiving this mail with regards to the ongoing PHED employee appraisal </p>
                    <p> You are requested as a REVIEWER to appraise the given employee whose link is included below</p>
                    <p> Thanks </p><br/><br/><br/>

                    <a href="{{ config('app.url') }}/reviewer/employee/{{$id}}/{{$staff_id}}">click here for employee appraisal form</a>

                    <p>Regards</p>
                    <p>HCM, PHED </p>
                </div>
                
            </div>
            @endif
             @if($res == "hr")
            <div class="content">
                <div class="title m-b-md text-primary">
                    PHED APPRAISAL
                    <p>A new employee appraisal has been submitted. Login for details or  
                    <a href="{{ config('app.url') }}/employee/{{$id}}/{{$staff_id}}">view details here</a>
                    </p>
                </div>
            </div>
            @endif
            
        </div>

    <script src="{{ asset('assets/js/core.min.j') }}s"></script>
    <script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
</html>

