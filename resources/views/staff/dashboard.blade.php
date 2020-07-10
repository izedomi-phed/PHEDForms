@extends('layouts.staff')

@section('content')
<div class="row justify-content-center mx-1 mb-5">
        <div class="col-md-12 text-center my-1">
            <h4 class="text-primary my-5"><strong> Welcome to PHED Forms portal</strong> </h4>
        </div>
       
        <div class="col-md-5 elevation-2 mr-2">
            <div class="row px-3 mb-2">
               
                <div class="col-md-12">
                    <div class="divider text-primary mb-2"><strong>PHED ACCESS FORMS</strong></div>
                     
                </div> 
            </div>
            <div class="row px-3 mt-4">
                <div class="col-md-12">
                    <p> With this feature, you can request for the various access forms</p>
                    <p> Currently availble forms: <a href="dashboard/dl_enhance">DLEnhance Access</a>,
                        <a href="dashboard/sage">Sage X3 ERP Access</a></p>
                    <p> To request access, click on the "Forms" link on the menu side bar</p>
                    <p> Select the access form as required</p>
                    <p> Fill and submit the form</p>
                    <p> Your request will be reviewed and status of your request reverted to you</p>
                </div> 
               
            </div>
            
        </div>
  
    </div>
@endsection