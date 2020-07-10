<template>

<div>

    <div class="row justify-content-center" v-show="!componentLoaded">
        <div class="col-md-6 text-center" style="margin-top:10%">
            <rotate-square-5 :size="'120px'"></rotate-square-5>
        </div>
    </div>

    <section class="mh-fullscreen bg-img p-20 bg-primary" v-show="componentLoaded">
        <canvas class="constellation"></canvas>

            <div class="row justify-content-center" v-if="request">
                <div class="col-md-6 px-8">  
                    <div class="card card-shadowed p-10 mb-0 elevation-4" >                 
                    <div class="text-center">
                        <a href='.'><img :src="'../../../images/PHEDLogo.jpg'" alt="phed logo"  style="width:100px;height:100px"/></a>
                    </div>

                    <h5 class="text-uppercase text-center">{{returnTitle()}}</h5>

                      <h6 class="text-center text-danger">{{formLabelText()}}</h6>

                    <template v-if="valErrors.length > 0">
                        <ul>
                            <li class="text-danger" v-for="(err, index) in valErrors" :key=index><strong>{{ err }}</strong></li>
                        </ul>             
                    </template>

                    <div class="row text-dark justify-content-center px-20 mb-2">
                        <div class="col-md-12"><h3 class="text-primary text-center"> STAFF DETAILS</h3> </div>
                        <div class="col-md-4">
                            <small>FIRST NAME</small><br/><strong>{{request.firstname}}</strong>
                        </div>
                        <div class="col-md-4">
                           <small>LAST NAME</small><br/><strong>{{request.lastname}}</strong>
                        </div>   
                         <div class="col-md-4">
                           <small>OTHER NAMES</small><br/><strong>{{request.otherNames}}</strong>
                        </div>  
                                          
                    </div>
                    <div class="row text-dark justify-content-center px-20 mb-2">
                        
                        <div class="col-md-6">
                            <small>STAFF EMAIL</small><br/><strong>{{request.email}}</strong>
                        </div>
                        <div class="col-md-6">
                           <small>STAFF ID</small><br/><strong>{{request.staff_id}}</strong>
                        </div>    
                                          
                    </div>
                    <div class="row text-dark justify-content-center px-20 mb-2">
                        <div class="col-md-6">
                            <small>JOB TITLE</small><br/><strong>{{request.designation}}</strong>
                        </div> 
                        <div class="col-md-6">
                           <small>JOB CATEGORY</small><br/> <strong>{{request.staff_type}}</strong>
                           
                        </div>
                       
                    </div>
                    <div class="row text-dark px-20 mb-2">
                          <div class="col-md-6">
                            <small>JOB DESCRIPTION/JUSTIFICATION </small><br/><strong>{{request.job_desc}}</strong>  
                        </div>                       
                    </div>
                    <div class="row text-dark px-20 mb-2" v-show="request.termination_date != null">
                          <div class="col-md-6">
                            <small>TERMINATION DATE </small><br/><strong>{{request.termination_date}}</strong>  
                        </div>                       
                    </div>
                    <div class="row text-dark px-20 mb-2">
                        <div class="col-md-6" v-show="request.role != null">
                           <small>ACCESS LEVEL REQUIRED</small> <br/><strong>{{request.role}}</strong>  
                        </div>
                         <div class="col-md-6">
                           <small>ACCESS ROLE</small> <br/><strong>{{request.access_level}}</strong>  
                        </div>
                    </div>
                    <div class="row text-dark justify-content-center px-20 mb-2" v-show="request.finance_module != null">
                        <div class="col-md-6">
                           <small>HR MODULE</small> <br/><strong>{{request.hr_module}}</strong>  
                        </div>
                         <div class="col-md-6">
                           <small>FINANCE MODULE</small> <br/><strong>{{request.finance_module}}</strong>  
                        </div>
                    </div>
                    <div class="row text-dark justify-content-center px-20 mb-2" v-show="request.hr_module != null">
                        <div class="col-md-6">
                           <small>PRIMARY OFFICE LOCATION</small> <br/><strong>{{request.location}}</strong>  
                        </div>
                         <div class="col-md-6">
                           <small>DEPARTMENT</small> <br/><strong>{{request.department}}</strong>  
                        </div>
                    </div>
                    <div class="row text-dark justify-content-center px-20 mb-2">
                        <div class="col-md-6">
                           <small>MOBILE NUMBER</small> <br/><strong>{{request.mobile_no}}</strong>  
                        </div>
                         <div class="col-md-6">
                           <small>WORK NUMBER</small> <br/><strong>{{request.work_no}}</strong>  
                        </div>
                    </div>
                    <div class="row text-dark justify-content-center px-20 mb-2 ">
                        <div class="col-md-6">
                           <small>NAME OF HEAD OF DEPARTMENT</small> <br/><strong>{{request.hod_name}}</strong>
                        </div>
                         <div class="col-md-6">
                           <small>EMAIL OF HEAD OF DEPARTMENT</small> <br/><strong>{{request.hod_email}}</strong>  
                        </div>
                    </div>

               
                                        
                        <div class="col-md-12" v-show="request.status == 'HOD_DECLINED'">
                           <small>HOD DECLINE COMMENT</small> <br/><strong class="text-dark">{{request.hod_comment}}</strong>  
                        </div>
                         <div class="col-md-12" v-show="request.status == 'AUDIT_DECLINED'">
                           <small>AUDIT DECLINE COMMENT</small> <br/><strong class="text-dark">{{request.audit_comment}}</strong>  
                        </div>  
                        <div class="col-md-12" v-show="request.status == 'HR_DECLINED'">
                           <small>HR DECLINE COMMENT</small> <br/><strong class="text-dark">{{request.hr_comment}}</strong>  
                        </div>  
                        <div class="col-md-12" v-show="request.status == 'FINANCE_DECLINED'">
                           <small>FINANCE DECLINE COMMENT</small> <br/><strong class="text-dark">{{request.finance_comment}}</strong>
                        </div>
                        <div class="col-md-12" v-show="request.status == 'IT_DECLINED'">
                           <small>IT DECLINE COMMENT</small> <br/><strong class="text-dark">{{request.it_comment}}</strong>
                        </div>                   
                   
                    
                    <div class="row text-dark d-block justify-content-center px-20 mb-2">
                        <p v-show="request.hod_action_date != null">completed by HOD: {{request.hod_action_date}}</p>
                        <p v-show="request.hr_action_date != null">completed by HR: {{request.hr_action_date}}</p>
                        <p v-show="request.finance_action_date != null">completed by FINANCE: {{request.finance_action_date}}</p>
                        <p v-show="request.audit_action_date != null">completed by AUDIT: {{request.audit_action_date}}</p>
                        <p v-show="request.it_action_date != null">completed by IT: {{request.it_action_date}}</p>
                        <p v-show="request.creator_action_date != null">Created On: {{request.creator_action_date}}</p>
                        
                    </div>

                    <div class="row text-dark justify-content-center px-20 mb-2" v-show="displayActionButton() == true">
                       <template >
                            <div class="col-md-6" v-show="request.approval != 'creator'">
                            <a @click.prevent="commentAlert(request.approval)" href="#" class="btn btn-danger" :disabled="isLoading">Decline Request</a>
                            </div>
                            <div class="col-md-6" v-show="request.approval != 'creator'">
                            <a @click.prevent="acceptRequest(request.approval)" href="#" class="btn btn-primary" :disabled="isLoading"> Accept Request</a> 
                            </div>
                       </template>
                       <template >
                            <div class="col-md-8 text-center justify-content-center" v-show="request.approval == 'creator'">
                            <p><small>After creating the required request access, click on the button to notify staff.</small></p>
                            <a @click.prevent="acceptRequest(request.approval)" href="#" class="btn btn-primary" :disabled="isLoading"> Yes, created</a> 
                            </div>
                       </template>
                    </div>
                    <div class="row text-dark justify-content-center px-20 mb-2" v-show="displayActionButton() == false && request.approval != 'it'">
                        
                        <p class="btn btn-danger"> STATUS: COMPLETED</p>
                       
                    </div>
                  
                    </div>
                </div>
                     
        </div>

    </section>

</div>


</template>
    



<script>

    import {RotateSquare5} from 'vue-loading-spinner'
    import Swal from 'sweetalert2'

    export default {
        props: {
            request: {
                type: Object,
                required: true,
            }
        },
        mounted() {
            console.log('Component mounted.')
            //this.getCurrentRequest()
        },
        created(){
            setTimeout(() => {
                this.componentLoaded = true
                //this.commentAlert()
            }, 2000)
        },
        components: {
            RotateSquare5
        },
        data(){
            return {              
                email: "",
                password: "",
                remember: true,
                valErrors: [],
                componentLoaded: false,
                status: "",
                isLoading: false,
                showActionButton: false,
                title: ''
            }
        },
        methods: {
            
            rejectRequest(approvedBy){
                this.isLoading = true         
                this.loadingAlert("Processing...please wait")
                this.processAction(approvedBy, "DECLINED")              
            },

            acceptRequest(approvedBy){
                this.isLoading = true
                this.request.comment = null;
                this.loadingAlert("Processing...please wait")
                this.processAction(approvedBy, "ACCEPTED")   
            },
            formLabelText(){
                if(this.request.approval == 'hod'){
                    this.formLabel = "HOD APPROVAL FORM"
                }
                if(this.request.approval == 'audit'){
                    this.formLabel = "AUDIT APPROVAL FORM"
                }
                if(this.request.approval == 'hr'){
                    this.formLabel = "HCM APPROVAL FORM"
                }
                if(this.request.approval == 'finance'){
                    this.formLabel = "FINANCE APPROVAL FORM"
                }
                if(this.request.approval == 'it'){
                    this.formLabel = "IT APPROVAL FORM"
                }
                if(this.request.approval == 'creator'){
                    this.formLabel = "ACCOUNT CREATION COMPLETION FORM"
                }

                return this.formLabel
            },
            processAction(approvedBy, approvalStatus){
                let data = {
                    'approved_by' : approvedBy,
                    'approval_status' : approvalStatus,
                    'decline_comment' : this.request.comment,
                    'request_id' : this.request.id,
                    'request_type': this.request.request_type
                }
                axios.post("../../../requests/approval", data).then((response) => {  
                   this.isLoading = false               
                   if(response.status == 200 || response.status == 201){

                        if(response.data.hasOwnProperty('errors')){                          
                            setTimeout(()=>{
                                this.errorAlert("Failed", this.valErrors[0])
                                 this.valErrors = response.data.errors;
                            }, 2000)
                        }else{  
                            console.log(response) 
                            setTimeout(()=>{
                                this.successAlert(approvalStatus, "staff request " + approvalStatus + " successfully", false)
                            
                            }, 1000)
                             setTimeout(()=>{
                                location.reload()                           
                            }, 5000) 
                            //this.details = response.data
                            console.log(response.data)
                                                      
                        }
                   }
                   else{
                        setTimeout(()=>{
                            this.errorAlert("An error occured", " Please refresh or try again later")
                        }, 2000)
    
                   }
                }).catch((error) => {
                    this.isLoading = false
                    setTimeout(()=>{
                        this.errorAlert("Something went wrong", "Error connecting to the server",)
                    }, 2000)       
                }); 
            },
            returnTitle(){
                if(this.request.request_type == "dl_enhance"){
                    this.title = "DLEnhance Access Request"
                }
                if(this.request.request_type == "sage"){
                    this.title = "Sage X3 ERP Access Request"
                }

                return this.title;
            },
            displayActionButton(){
                if(this.request.approval == 'hod' && this.request.hod_action_date == null){
                    return true
                }
                if(this.request.approval == 'audit' && this.request.audit_action_date == null){
                    return true
                }
                if(this.request.approval == 'hr' && this.request.hr_action_date == null){
                    return true
                }
                if(this.request.approval == 'finance' && this.request.finance_action_date == null){
                    return true
                }
                if(this.request.approval == 'it' && this.request.it_action_date == null){
                    return true
                }
                if(this.request.approval == 'creator' && this.request.creator_action_date == null){
                    return true
                }
                return false;
            },
            loadingAlert(footer){
                Swal.fire({
                    html: '<i class="fa fa-circle-o-notch fa-spin text-primary fa-3x"></i>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    footer: footer
                })
            },
            errorAlert(title, text){
                Swal.fire({
                    icon: 'error',
                    position: 'center',
                    title: 'Oops..'+title,
                    text: text,
                    showConfirmButton: true,
                })
            },
            successAlert(text, footer, toast){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: text,
                    toast: toast,
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    footer: footer
                })
            },
            infoAlert(text, footer){
                 Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: "Ooop..",
                    text: text,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    footer: footer
                })
            },
            commentAlert(){
                Swal.fire({
                title: '<html><small class="text-dark">Please state reason for decline</small></html>',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: false,
                confirmButtonText: 'submit',
                showLoaderOnConfirm: false,
                allowOutsideClick: true
                }).then((result) => {
                if (result.value) {
                  console.log(result.value)
                    if(result.value.trim().length == 0){
                        Swal.fire({
                        title: `${result.value}`,
                        
                        })
                    }
                    else{
                        this.request.comment = result.value
                        this.rejectRequest(this.request.approval)
                    }
                   
                }
                })
             }
            
        }
    }
</script>
