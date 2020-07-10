<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PHED APPRAISALS</title>

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

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .title {
                font-size: 25px;
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
  
            td, th, .text-center{
                text-align: center;
            }
            th > strong{
                color: #636b6f;
            }
            body > div > .table > tbody > .row{
                padding: 10px;
                color:green;
            }
            #i{
                color:red;
            }
            #row1{
                padding: 10px;
                margin-top: 15px;
                margin-bottom: 50px;
            }
            #row{
                padding: 10px;
                margin-top: 15px;
                margin-bottom: 50px;
                color: yellow;
            }
           
        </style>
    </head>
    <body>
            
            <div style="margin-top:25px" class="text-center">
                <h3>PHED APPRAISALS</h3>
            </div>

            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr><th colspan='4'><h3>Employee Details</h3></th></tr>
                        
                        <tr id="row1">
                            <th><strong>Name</strong></th>
                            <th><strong>Staff Id</strong></th>
                            <th><strong>Designation</strong></th>
                            <th><strong>Email</strong></th>                                       
                        </tr>
                    </thead>
                    <tbody>
                         <tr class="item">
                            <td>{{$data['employee']['name']}}</td>
                            <td>{{$data['employee']['staff_id']}}</td>
                            <td>{{$data['employee']['designation']}}</td>
                            <td>{{$data['employee']['email']}}</td>                                       
                        </tr>
                    </tbody>
                   
                </table>
            </div>
            <br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                        
                        <tr>
                            
                            <th colspan="2"><strong>Date Of Employment</strong></th>
                            <th colspan="2"><strong>Highest Academic Qualification</strong></th>
                            <th colspan="2"><strong>IBC</strong></th>
                            <th colspan="1"><strong></strong></th>                                       
                        </tr>                                           
                        
                    </thead>
                    <tbody>
                         <tr class="item">
                            <td colspan="2">{{$data['employee']['doe']}}</td>
                            <td colspan="2">{{$data['employee']['haq']}}</td>
                            <td colspan="2">{{$data['employee']['ibc']}}</td>
                            <td colspan="1"></td>                                       
                        </tr>
                    </tbody>
                   
                </table>
            </div>
            <br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                      
                        <tr class="row">
                            <th><strong>Appraisal's Name</strong></th>
                            <th><strong>Appraisal's Email</strong></th>
                            <th><strong>Reviewer's Name</strong></th>
                            <th><strong>Reviewer's Email</strong></th>                                       
                        </tr>   
                    </thead>
                    <tbody>
                         <tr class="item">
                            <td>{{$data['supervisor']['appraiser_name']}}</td>
                            <td>{{$data['supervisor']['appraiser_email']}}</td>
                            <td>{{$data['supervisor']['reviewer_name']}}</td>
                            <td>{{$data['supervisor']['reviewer_email']}}</td>                                       
                        </tr>
                    </tbody>
                   
                </table>
            </div>
            <br/><br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <td colspan='6'>
                                <h3><strong>Part I : Self-Appraisal (The overall weightage for this section is 80%)</strong></h3>
                                <small>(Rating Scale - 1 to 5 point, 1 – Poor, 2 - Average, 3 - Good, 4 - Very Good, 5 - outstanding)</small>
                            </td>
                         </tr>

                         <!-- financial performance target -->
                         <tr>
                            <td colspan='6'>
                                <h3><strong>Financial Performance Target and Achievement </strong></h3>
                            </td>
                         </tr>
                        <tr class="row">
                            <th><strong>Financial Dimension Task</strong></th>
                            <th><strong>Target Planned</strong></th>
                            <th><strong>Target Achieved</strong></th>
                            <th><strong>Rating by Self</strong></th>    
                            <th><strong>Rating by Appraiser</strong></th>   
                            <th><strong>Rating by Reviewer</strong></th>                                      
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['financialP'] as $f)                            
                            <tr class="item">
                                <td>{{$f->performance_title}}</td>
                                <td>{{$f->target_planned}}</td>
                                <td>{{$f->target_achieved}}</td>
                                <td>{{$f->rating_by_self}}</td>
                                <td>{{$f->rating_by_appraiser}}</td>
                                <td>{{$f->rating_by_reviewer}}   </td>
                            </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            <br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                         <tr>
                            <td colspan='6'>
                                <h3><strong>Customer Performance Target and Achievement </strong></h3>
                            </td>
                         </tr>
                        <tr class="row">
                            <th><strong>Customer Dimension Task</strong></th>
                            <th><strong>Target Planned</strong></th>
                            <th><strong>Target Achieved</strong></th>
                            <th><strong>Rating by Self</strong></th>    
                            <th><strong>Rating by Appraiser</strong></th>   
                            <th><strong>Rating by Reviewer</strong></th>                                      
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['customerP'] as $f)                            
                            <tr class="item">
                                <td>{{$f->performance_title}}</td>
                                <td>{{$f->target_planned}}</td>
                                <td>{{$f->target_achieved}}</td>
                                <td>{{$f->rating_by_self}}</td>
                                <td>{{$f->rating_by_appraiser}}</td>
                                <td>{{$f->rating_by_reviewer}}   </td>
                            </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            <br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                         <tr>
                            <td colspan='6'>
                                <h3><strong>Process/Operations Performance Target and Achievement </strong></h3>
                            </td>
                         </tr>
                        <tr class="row">
                            <th><strong>Process/Operations Dimension Task</strong></th>
                            <th><strong>Target Planned</strong></th>
                            <th><strong>Target Achieved</strong></th>
                            <th><strong>Rating by Self</strong></th>    
                            <th><strong>Rating by Appraiser</strong></th>   
                            <th><strong>Rating by Reviewer</strong></th>                                      
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['processP'] as $f)                            
                            <tr class="item">
                                <td>{{$f->performance_title}}</td>
                                <td>{{$f->target_planned}}</td>
                                <td>{{$f->target_achieved}}</td>
                                <td>{{$f->rating_by_self}}</td>
                                <td>{{$f->rating_by_appraiser}}</td>
                                <td>{{$f->rating_by_reviewer}}   </td>
                            </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            <br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                         <tr>
                            <td colspan='4'>
                                <h3><strong>Behavioural Attributes (Weightage - 15 %) </strong></h3>
                            </td>
                         </tr>
                        <tr class="row">
                            <th><strong>Process/Operations Dimension Task</strong></th>
                            <th><strong>Rating by Self</strong></th>    
                            <th><strong>Rating by Appraiser</strong></th>   
                            <th><strong>Rating by Reviewer</strong></th>                                      
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['behaviourP'] as $f)                            
                            <tr class="item">
                                <td>{{$f->performance_title}}</td>
                                <td>{{$f->rating_by_self}}</td>
                                <td>{{$f->rating_by_appraiser}}</td>
                                <td>{{$f->rating_by_reviewer}}   </td>
                            </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            <br/><br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                         <tr>
                            <td colspan='6'>
                                <h3><strong>Training (Weightage - 5%)  </strong></h3>
                            </td>
                         </tr>
                        <tr class="row">
                            <th><strong>Training</strong></th>
                            <th><strong>Target Planned</strong></th>
                            <th><strong>Target Achieved</strong></th>
                            <th><strong>Rating by Self</strong></th>    
                            <th><strong>Rating by Appraiser</strong></th>   
                            <th><strong>Rating by Reviewer</strong></th>                                      
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['trainingP'] as $f)                            
                            <tr class="item">
                                <td>{{$f->performance_title}}</td>
                                <td>{{$f->target_planned}}</td>
                                <td>{{$f->target_achieved}}</td>
                                <td>{{$f->rating_by_self}}</td>
                                <td>{{$f->rating_by_appraiser}}</td>
                                <td>{{$f->rating_by_reviewer}}   </td>
                            </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            <br/><br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                         <tr>
                            <td colspan='4'>
                                <h3><strong>Overall Summary of Performance of Appraisee   </strong></h3>
                            </td>
                         </tr>
                         <tr class="row">
                            <th><strong>Appraiser - Performance Rating (80% weightage)</strong></th>
                            <th><strong>Appraiser - Attributes (15% weightage)</strong></th>
                            <th><strong>Appraiser - Training (5% weightage)</strong></th>
                            <th><strong>Appraiser - Overall Rating</strong></th>                                                                    
                        </tr>  
                    </thead>
                    <tbody>
                        <tr class="item">
                            <td>{{$data['summary']['a_performance']}}</td>
                            <td>{{$data['summary']['a_attributes']}}</td>
                            <td>{{$data['summary']['a_training']}}</td>
                            <td>{{$data['summary']['a_overall']}}</td>
                        </tr>
                    </tbody>
                   
                </table>
            </div><br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                        
                         <tr class="row">
                            <th><strong>Reviewer - Performance Rating (80% weightage)</strong></th>
                            <th><strong>Reviewer - Attributes (15% weightage)</strong></th>
                            <th><strong>Reviewer - Training (5% weightage)</strong></th>
                            <th><strong>Reviewer - Overall Rating</strong></th>                                                                    
                        </tr>  
                    </thead>
                    <tbody>
                        <tr class="item">
                            <td>{{$data['summary']['r_performance']}}</td>
                            <td>{{$data['summary']['r_attributes']}}</td>
                            <td>{{$data['summary']['r_training']}}</td>
                            <td>{{$data['summary']['r_overall']}}</td>
                        </tr>
                    </tbody>
                   
                </table>
            </div><br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                        
                         <tr class="row">
                            <th><strong>Head Of Human Capital Management </strong></th>
                            <th><strong>Chief People Officer(CPO) </strong></th>                                                                   
                        </tr>  
                    </thead>
                    <tbody>
                       <tr class="item">
                            <td>{{$data['summary']['hhcm']}}</td>
                            <td>{{$data['summary']['cpo']}}</td>
                        </tr>
                    </tbody>
                   
                </table>
            </div>
            <br/><br/>
            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <td colspan='4'>
                                <h3><strong>Part II</strong></h3>
                                <p>Recommendations (completed by appraiser)</p>
                            </td>
                        </tr>     
                        <tr class="row">
                            <th><strong><strong>Job Rotation</strong> </strong></th>
                            <th><strong><strong>Job Enhancement </strong> </strong></th>
                            <th><strong><strong>Promotion to Next Level / Grade </strong> </strong></th>
                            <th><strong><strong>Training Needs </strong> </strong></th>
                                                                                               
                        </tr>  
                    </thead>
                    <tbody>
                       <tr class="item">
                            <td>{{$data['recommendation']['job_rotation']}}</td>
                            <td>{{$data['recommendation']['job_enhancement']}}</td>
                            <td> {{$data['recommendation']['promotion']}}</td>
                            <td> {{$data['recommendation']['training']}}</td>
                        </tr>
                    </tbody>
                   
                </table>
            </div>
            <br/><br/>
            
            
            <div class="table-responsive">     
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr><td>Job Rotation Recommendation</td></tr>                            
                    </thead>
                    <tbody>
                       <tr class="item"><td>{{$data['recommendation']['job_rotation_recommendation']}}</td></tr>
                    </tbody>                 
                </table>
            </div>
            
            <br/><br/>
             <div class="table-responsive">     
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr><td>Job Enhancement Recommendation</td></tr>                            
                    </thead>
                    <tbody>
                       <tr class="item"><td>{{$data['recommendation']['job_enhancement_recommendation']}}</td></tr>
                    </tbody>                 
                </table>
            </div>
            <br/><br/>
            <div class="table-responsive">     
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr><td>Promotion Needed</td></tr>                            
                    </thead>
                    <tbody>
                       <tr class="item"><td> {{$data['recommendation']['promotion_justification']}}</td></tr>
                    </tbody>                 
                </table>
            </div>
            <br/><br/>
             <div class="table-responsive">     
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr><td>Training Needs</td></tr>                            
                    </thead>
                    <tbody>
                       <tr class="item"><td> {{$data['recommendation']['training_recommendation']}}</td></tr>
                    </tbody>                 
                </table>
            </div>

    </body>
</html>
