<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PHED</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <script src="{{ asset('assets/js/core.min.j') }}s"></script>
        <script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>

        <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/thesaas.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
       
    </head>
    <body>
        
    <div class="container my-20 p-30 bg-info text-dark" style="background-color:#55727b">
            @if($appraiser_completion_status->overall == 1)

               <h3 class="text-center"> Thank you <br/>You have successfully completed and submitted the review for this employee </h3>

            @else
                <form method="post" action="../../../performance_appraisal_by_appraiser">
                    @csrf 
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <p><strong>Part I : Self-Appraisal (The overall weightage for this section is 80%)</strong></p>
                            <p>(Weightage - %)</p>         
                            <p>(Rating Scale - 1 to 5 point, 1 – Poor, 2 - Average, 3 - Good, 4 - Very Good, 5 - outstanding)</p>
                            
                            @include('msg')
                           
                                @include('a_performance_forms.financial')
                                @include('a_performance_forms.customer')
                                @include('a_performance_forms.process')
                                @include('a_performance_forms.behavioural')
                                @include('a_performance_forms.training')
                                <hr class="my-1">

                                <div class="row justify-content-center">
                                    <div class="col-md-12 text-center">
                                        <p>Overall Summary of Performance of Appraisee</p>
                                    </div>
                                </div>
                                    
                                @include('a_performance_forms.overall')
                    
                                                                   
                        </div>
                    </div>
                    <hr class="my-1 text-primary">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <p><strong>Part II</strong></p>
                            <p>Recommendations</p>
                        </div>                
                    </div>
                    @include('a_performance_forms.recommendation')
                    <div class="row text-left">
                        <div class="col-md-4">  
                            <input type="hidden" name="staff_id" class="form-control" value="{{$staff_id}}" /> 
                            <p class="text-center"><button type="button" class="btn btn-lg btn-round btn-danger" data-toggle="modal" data-target="#exampleModal">SUBMIT</button></p>
                            <button type="submit" name="submit" class="btn btn-white mb-10 d-none" id="submit">Submit</button>                      
                        
                        </div>
                    </div>
                </form>
            @endif
     
    </div>

        
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalLabel">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <p> Please confirm you have reviewed and rated employee as required. Your review and ratings cannot be changed after submission</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submit-modal">Yes, Continue</button>
            </div>
            </div>
        </div>
    </div>


    
    <script>
        $(document).ready(function(){

            $('#submit-modal').click(function(){
                $('#submit').click();
                $('#exampleModal').modal('hide')
            });

        });
    </script>

    
    <script>

        $(document).ready(function(){
            var performanceRating = 16;
            var attributeRating = 1;
            var trainingRating = 1;
            var overallRating = performanceRating + attributeRating + trainingRating;

            $('#pr').val(performanceRating);
            $('#ar').val(attributeRating);
            $('#tr').val(trainingRating);
            $('#or').val(overallRating);

            $(document).on('change','.performance', function(){
                
                frs_sum = 0;
                crs_sum = 0;
                prs_sum = 0;
                var totalSumOfRating;
               

                var frs = document.getElementsByName('rating_by_appraiser_f[]');
                var crs = document.getElementsByName('rating_by_appraiser_c[]');
                var prs = document.getElementsByName('rating_by_appraiser_p[]');

                           
                for (var i = 0; i < frs.length; i++) {
                    var fr=frs[i];
                    frs_sum = Number(frs_sum) + Number(fr.value);             
                }
                for (var i = 0; i < crs.length; i++) {
                    var cr=crs[i];
                    crs_sum = Number(crs_sum) + Number(cr.value);             
                }
                for (var i = 0; i < prs.length; i++) {
                    var pr=prs[i];
                    prs_sum = Number(prs_sum) + Number(pr.value);             
                }
                totalSumOfRating = Number(prs_sum) + Number(crs_sum) + Number(frs_sum)
                var numberOfTask = Number(frs.length) + Number(crs.length) + Number(prs.length)
                var totalTaskWeight = Number(numberOfTask * 5);

                


                /*console.log("f length: " + frs.length);
                console.log("c length: " + crs.length);
                console.log("p length: " + prs.length);

                console.log("f: " + frs_sum);
                console.log("c: " + crs_sum);
                console.log("p: " + prs_sum);

                console.log("total: " + totalSumOfRating);
                */

                performanceRating = Math.round((totalSumOfRating/totalTaskWeight) * 80);
                console.log(performanceRating);

                $('#pr').val(performanceRating);
                $('#or').val(attributeRating + performanceRating + trainingRating);
            
            });

            $(document).on('change', '.attribute', function(){
                var brs_sum = 0;
                var totalSumOfRating;

                var brs = document.getElementsByName('rating_by_appraiser_b[]');
                
                for (var i = 0; i < brs.length; i++) {
                    var br=brs[i];
                    brs_sum = Number(brs_sum) + Number(br.value);             
                }

                totalSumOfRating = Number(brs_sum)
                var numberOfTask = Number(brs.length)
                var totalTaskWeight = Number(numberOfTask * 5);

                if(numberOfTask == 1){
                    attributeRating = Math.round((totalSumOfRating/totalTaskWeight) * 5);
                }
                if(numberOfTask == 2){
                    attributeRating = Math.round((totalSumOfRating/totalTaskWeight) * 10);
                }
                if(numberOfTask == 3){
                    attributeRating = Math.round((totalSumOfRating/totalTaskWeight) * 15);
                }

                $('#ar').val(attributeRating);
                $('#or').val(attributeRating + performanceRating + trainingRating);
                


            });

             $(document).on('change', '.training', function(){
                var trs_sum = 0;
                var totalSumOfRating;

                var trs = document.getElementsByName('rating_by_appraiser_t[]');
                
                for (var i = 0; i < trs.length; i++) {
                    var tr=trs[i];
                    trs_sum = Number(trs_sum) + Number(tr.value);             
                }

                totalSumOfRating = Number(trs_sum)
                var numberOfTask = Number(trs.length)
                var totalTaskWeight = Number(numberOfTask * 5);

                trainingRating = Math.round((totalSumOfRating/totalTaskWeight) * 5);
                console.log(trainingRating);

                $('#tr').val(trainingRating);
                $('#or').val(attributeRating + performanceRating + trainingRating);


            });
        });    
    </script>
       


   
    </body>
</html>
