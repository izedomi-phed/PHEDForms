<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PHED</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/thesaas.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

        
    </head>
    <body>

    <div class="container my-20 p-30 text-dark" style="background-color:#00b3ab" >
        
        <div class="row justify-content-center text-center">
            <h5>PHED APPRAISAL</h5>
        </div>
         @include('e_performance_forms.personal')       
         <hr/>
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <p><strong>Part I : Self-Appraisal (The overall weightage for this section is 80%)</strong></p>
                <p>(Weightage - %)</p>         
                <p>(Rating Scale - 1 to 5 point, 1 – Poor, 2 - Average, 3 - Good, 4 - Very Good, 5 - outstanding)</p>
      
                @include('e_performance_forms.financial')
                @include('e_performance_forms.customer')
                @include('e_performance_forms.process')
                @include('e_performance_forms.behavioural')
                @include('e_performance_forms.training')              
            </div>
        </div>
        <div class="row divider justify-content-center">
            <h5> Overall Summary of Performance of Appraisee</h5>           
        </div>
        <div class="row">
            <div class="col-md-12 text-center">                      
                @include('e_performance_forms.overall')
            </div>
        </div>
        <hr class="my-1 bg-secondary">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <p><strong>Part II</strong></p>
                <p>Recommendations (completed by appraiser)</p>
            </div>
        </div>
        
       
        @include('e_performance_forms.recommendation')
        
                       
    </div>
       

    <script src="{{ asset('assets/js/core.min.j') }}s"></script>
    <script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    </body>
</html>
