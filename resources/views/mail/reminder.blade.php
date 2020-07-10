<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PHED APPRAISALS</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/thesaas.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    </head>
    <body>
        <div class="flex-center position-ref full-height">



            @if($request_type == "dl_enhance")
                <?php $subject = "PHED DLEnhance"; ?>
            @else
                <?php $subject = "PHED Sage X3 ERP"; ?>
            @endif

             @if($stat == "START_APPRAISAL" || $stat == "TO_COMPLETE_FORM")
                <div class="content">
                    <div class="title m-b-md text-primary">
                        REMINDER: PHED APPRAISAL
                        <p> You are receiving this mail with regards to the ongoing PHED employee appraisal </p>
                        <p> You have not started with your appraisal process, please do well to start as your compliance with the process is necessary</p>
                        <p> Thanks </p><br/><br/><br/>

                        <p>Regards</p>
                        <p>HCM, PHED </p>
                    </div>
                    
                </div>
            @endif

            @if($stat == "WAIT_APPRAISER")
                <div class="content">
                    <div class="title m-b-md text-primary">
                        REMINDER: PHED APPRAISAL
                        <p> You are receiving this mail with regards to the ongoing PHED employee appraisal </p>
                        <p> You currently have an employee appraisal request yet to be completed.Please do well to complete and submit</p>
                        <p> Thanks </p><br/><br/><br/>

                        

                        <p>Regards</p>
                        <p>HCM, PHED </p>

                    </div>
                
                </div>
            @endif

    
            @if($stat == "WAIT_REVIEWER")
                <div class="content">
                    <div class="title m-b-md text-primary">
                        REMINDER: PHED APPRAISAL
                        <p> You are receiving this mail with regards to the ongoing PHED employee appraisal </p>
                        <p> You currently have an employee appraisal request yet to be completed.Please do well to complete and submit</p>
                        <p> Thanks </p><br/><br/><br/>


                        <p>Regards</p>
                        <p>HCM, PHED </p>
                    </div>
                    
                </div>
            @endif
         
            @if($stat == "hr")
                <div class="content">
                    <div class="title m-b-md text-primary">
                        REMINDER: PHED APPRAISAL
                        <p>A new employee appraisal has been submitted. Login for details or  
                        <a href="{{ config('app.url') }}/employee/{{$id}}/{{$staff_id}}">view details here</a>
                        </p>
                    </div>
                </div>
            @endif

            @if($stat == "TO_HOD")
            <div class="content">
                <div class="title m-b-md text-primary">
                    
                    <p class="text-primary"><strong>{{$subject}} Access Requests</strong></p><br/>
                    <p> You are recieving this email with respect to a {{$subject}} access request from a staff in your Department </p>
                    <p> In accordance to {{$subject}} access request policies, you are required as the staff's Head of Department, 
                    to verify the request and accept or decline as appropriate.</p>
                    
                    <a href="{{ config('app.url') }}/requests/{{$request_type}}/{{$id}}/{{$staff_id}}?approval=hod">click here to see request details</a><br/><br/>

                    <p> Thanks.</p><br/>

                    <p>Best regards</p>
                    <p>I.T PHED </p>
                </div>
                
            </div>
            @endif

            @if($stat == "TO_HR")
            <div class="content">
                <div class="title m-b-md text-primary">
                    
                    <p class="text-primary"><strong>{{$subject}}</strong></p><br/>
                    <p> You are recieving this email with respect to a {{$subject}} access request from a staff </p>
                    <p> In accordance to {{$subject}} access request policies, you are required to verify the request and accept or decline as appropriate.</p>
                    
                    <a href="{{ config('app.url') }}/requests/{{$request_type}}/{{$id}}/{{$staff_id}}?approval=hr">click here to see request details</a><br/><br/>

                    <p> Thanks.</p><br/>

                    <p>Best regards</p>
                    <p>I.T PHED </p>
                </div>
                
            </div>
            @endif

    
            @if($stat == "TO_FINANCE")
            <div class="content">
                <div class="title m-b-md text-primary">
                    
                    <p class="text-primary"><strong>{{$subject}}</strong></p><br/>
                    <p> You are recieving this email with respect to a {{$subject}} access request from a staff </p>
                    <p> In accordance to {{$subject}} access request policies, you are required to verify the request and accept or decline as appropriate.</p>
                    
                    <a href="{{ config('app.url') }}/requests/{{$request_type}}/{{$id}}/{{$staff_id}}?approval=finance">click here to see request details</a><br/><br/>

                    <p> Thanks.</p><br/>

                    <p>Best regards</p>
                    <p>I.T PHED </p>
                </div>
                
            </div>
            @endif


            @if($stat == "TO_AUDIT")
            <div class="content">
                <div class="title m-b-md text-primary">
                    
                    <p class="text-primary"><strong>{{$subject}}</strong></p><br/>
                    <p> You are recieving this email with respect to a {{$subject}} access request from a staff </p>
                    <p> In accordance to {{$subject}} access request policies, you are required to verify the request and accept or decline as appropriate.</p>
                    
                    <a href="{{ config('app.url') }}/requests/{{$request_type}}/{{$id}}/{{$staff_id}}?approval=audit">click here to see request details</a><br/><br/>

                    <p> Thanks.</p><br/>

                    <p>Best regards</p>
                    <p>I.T PHED </p>
                </div>
                
            </div>
            @endif

            @if($stat == "TO_IT")
            <div class="content">
                <div class="title m-b-md text-primary">
                    
                    <p class="text-primary"><strong>{{$subject}}</strong></p><br/>
                    <p> You are recieving this email with respect to a {{$subject}} access request from a staff </p>
                    @if($request_type == 'dl_enhance')
                    <p> Staff {{$subject}} access request has been successfully approved by the HOD and AUDIT </p>
                    @else
                    <p> Staff {{$subject}} access request has been successfully approved by the HOD, FINANCE, HCM and AUDIT </p>
                    @endif

                    <p> Login into your account to view request details</p>
                                  
                    <p> Thanks.</p><br/>

                    <p>Best regards</p>
                    <p>I.T PHED </p>
                </div>               
            </div>
            @endif

            @if($stat == "TO_CREATE")
            <div class="content">
                <div class="title m-b-md text-primary">
                    
                    <p class="text-primary"><strong>{{$subject}}</strong></p><br/>
                    <p> You are recieving this email with respect to a {{$subject}} access request from a staff </p>
                    @if($request_type == 'dl_enhance')
                    <p> Staff {{$subject}} access request has been successfully approved by the HOD, AUDIT AND IT </p>
                    @else
                    <p> Staff {{$subject}} access request has been successfully approved by the HOD, FINANCE, HCM, AUDIT AND IT</p>
                    @endif

                    <p> Please do well to create the required account access</p>

                    
                    <a href="{{ config('app.url') }}/requests/{{$request_type}}/{{$id}}/{{$staff_id}}?approval=creator">click here to see request details</a><br/><br/>

                                  
                    <p> Thanks.</p><br/>

                    <p>Best regards</p>
                    <p>I.T PHED </p>
                </div>               
            </div>
            @endif


           

        </div>

    <script src="{{ asset('assets/js/core.min.j') }}s"></script>
    <script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
</html>

