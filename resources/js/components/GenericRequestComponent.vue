<template>


<div class="container">
    <div class="row justify-content-center" v-show="!componentLoaded">
        <div class="col-md-6 text-center" style="margin-top:10%">
            <rotate-square5 :size="'120px'"></rotate-square5>
        </div>
    </div>
    <div class="row justify-content-center" v-show="componentLoaded">
        <div class="col-md-6">
   
            <form method="post" class="bg-white px-30 elevation-4 mb-20" id="dlenhanceform" @submit.prevent="verifyDetails">
                
                <div class="row px-3">
                    <div class="col-md-12 text-center mt-1">
                        <h5 class="text-primary mt-1 mb-0">
                             
                            <img :src="'../images/PHEDLogo.jpg'" alt="phed logo"  style="width:100px;height:70px"/><br/>
                            <strong> {{title}}</strong> 
                        </h5>
                        <p id="add">
                            Information Technology Department<br/>
                            Port-Harcourt Electricity Distribution Company<br/>
                            118 Ordinance Junction, Trans Amadi Layout.<br/>
                            Email: it@phed.com.ng<br/>
                            Tel: 08139834029
                        </p>
                        <template v-if="valErrors.length > 0">
                            <ul class="mt-3 text-left">
                                <li class="text-danger" v-for="(err, index) in valErrors" :key=index>{{ err }}</li>
                            </ul>              
                        </template>
                         <div class="alert alert-danger alert-dismissible fade show" role="alert" v-show="currentRequestStatus != ''">
                            <p class="bg-danger">
                                {{currentRequestStatus}}<br/><span class="">{{remarks}}</span>
                            </p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>       
                    </div>
                </div>
                <hr class="divider">
                <p class="des">
                    <strong>This account will be used to access {{type}} application at PHEDC. 
                        Processing of this application form requires 1 or more working days.
                    </strong>
                </p>
                <hr class="divider">
               

                <div class="row px-3">
                    
                    <!-- First Name -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="firstName">First Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="firstName" v-model="details.first_name" :readonly="details.first_name != ''">
                        </div>
                    </div>
                    <!-- Last name -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lastName">Last Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="lastName" v-model="details.last_name" :readonly="details.last_name != ''">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lastName">Other Names<span class="text-danger"></span></label>
                            <input type="text" class="form-control form-control-sm" v-model="details.other_name">
                        </div>
                    </div>

                    <!-- staff id -->   
                   <!-- <div class="col-md-2">
                        <div class="form-group">
                            <label for="staffId">Staff ID</label>
                            <input type="text" class="form-control form-control-sm" id="staffId" v-model="details.staff_id" readonly>
                        </div>
                    </div> -->
                        
                    <!-- official email --> 
                   <!-- <div class="col-md-7">
                        <div class="form-group">
                            <label for="officer_email">Official Email<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="firstName" v-model="details.official_email" readonly>
                        </div>
                    </div> -->

                    <!-- job title -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="designation">Job Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="designation" v-model="details.designation">
                        </div>
                    </div>  

                                      
                    <!-- Staff Type -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="officer_email">Staff type<span class="text-danger">*</span></label><br/>
                            <select v-model="details.staff_type">
                                <option v-for="(staffType, index) in staffTypes" :key="index">{{staffType}}</option>
                            </select>
                        </div>
                    </div>
 
                    <!-- brief job description -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="officer_email">Brief Job Description/Justification<span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" v-model="details.job_desc"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Roles -->                
                <div class="row px-3 mb-3" v-show="request_type == 'dl_enhance'">
                    <div class="col-md-12">
                    <small class="text-dark"> <strong>Role</strong></small>
                    </div>
                    <div class="col-md-4 d-flex" v-for="(role, index) in roles" :key="'B-'+index">
                        <div class="mr-2">
                            <input type="checkbox" class="mx-1" :value="role" v-model="details.role" :id="role" /><span class="des">{{role}} </span>
                        </div> 
                    </div> 
                </div>

                <!-- access levels -->
                <small class="px-3 text-dark"> <strong>Access Level</strong></small><br/>
                <div class="row px-3 mb-3">                      
                    <div class="col-md-4 d-flex" v-for="(accessLevel, index) in accessLevels" :key="'A-'+index">
                        <div class="mr-2">
                            <input type="checkbox" class="mx-1" :value="accessLevel" v-model="details.access_level" /><span class='des'>{{accessLevel}} </span>
                        </div> 
                    </div>                   
                </div>

                <!-- ERP X3 Finance Module -->
                <div class="row px-3 mb-3" v-show="request_type == 'sage'">
                    <div class="col-md-12">
                    <small class="text-dark"> <strong>ERP X3 Finance Module</strong></small>
                    </div>
                    <div class="col-md-5 d-flex" v-for="(role, index) in financeModule" :key="'B-'+index">
                        <div class="mr-2">
                            <input type="checkbox" class="mx-1" :value="role" v-model="details.finance_module" :id="role" /><span class="des">{{role}} </span>
                        </div> 
                    </div> 
                </div>

                  <!-- ERP X3 HR Module -->
                <div class="row px-3 mb-3" v-show="request_type == 'sage'">
                    <div class="col-md-12">
                    <small class="text-dark"> <strong>ERP X3 HR Module</strong></small>
                    </div>
                    <div class="col-md-6 d-flex" v-for="(role, index) in hrModule" :key="'B-'+index">
                        <div class="mr-2">
                            <input type="checkbox" class="mx-1" :value="role" v-model="details.hr_module" :id="role" /><span class="des">{{role}} </span>
                        </div> 
                    </div> 
                </div>

                <div class="row px-3">
                    <!-- primary office location -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">Primary Office Location<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" v-model="details.location">
                        </div>
                    </div> 
                    <!-- department -->    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="staffId">Department<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="staffId" v-model="details.department">
                        </div>
                    </div> 

                     <!-- department -->    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="staffId">Termination Date(for temporary positions)</label>
                            <input type="text" class="form-control form-control-sm" id="staffId" v-model="details.termination_date">
                        </div>
                    </div> 

                    <!-- Mobile Number -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">Mobile Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" v-model="details.mobile_no">
                        </div>
                    </div> 

                     <!-- Work Number -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">Work Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" v-model="details.work_no">
                        </div>
                    </div> 

                     <!-- HOD NAME -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">H.O.D Fullname<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" v-model="details.hod_name">
                        </div>
                    </div> 

                     <!-- HOD EMAIL -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">H.O.D Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm required" v-model="details.hod_email">
                        </div>
                    </div> 

                    
                    
                </div>
                <p class="des mb-3">
                    <strong>An access account will be created for only staff of the departments that require access to the {{type}} application.</strong>
                    
                 </p>
                <hr/>
               
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="mr-2 mb-3">
                            <input type="checkbox" class="mx-1"  v-model="details.accepted" />
                            <small class="text-dark">I Accept DLEnhance <a class="text-primary" @click.prevent="openModal('terms')">terms and conditions</a>
                            </small>
                            
                        </div> 
                    </div> 
                 
                         <button name="submit" class="btn btn-round btn-primary mb-10" v-show="currentRequestStatus == ''">
                             Submit FOR APPROVALS
                        </button>
                  
                   
                </div>

            </form>
        </div>
    </div>
    
    <div class="modal fade" id="terms" ref="m" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" v-show="modalState == 'terms'"><strong>{{type}} TERMS AND CONDITIONS</strong></h5>
                    <h5 class="modal-title text-danger" v-show="modalState == 'flow'"><strong>APPROVAL STAGES</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                                  
                <div class="modal-body">
                    <p v-show="modalState == 'terms'">
                       1. Users are requested to keep the given user id and password confidential.<br/>
                       2. Please change your password at least once in every three months, refer to PHED password Policy.<br/>
                       3. <strong>PHED</strong> is neither responsible nor accountable for this type of misuse of the compromised accounts.
                        Gross misuse might be detected by automated monitoring tools, which in turn will automatically deactivate the account.<br/>
                       4. PHED is neither responsible nor accountable for this type of misuse of the compromised accounts. 
                       Gross misuse might be detected by automated monitoring tools, which in turn will automatically deactivate the account.
                    </p>
                    <p v-show="modalState == 'flow'">
                       1. On submission, the form is sent your HOD for approval<br/>
                       2. After the HOD approval, it is sent to the AUDIT for approval<br/>
                       3. After which it is forwarded to the IT Department
                    </p>                           
                </div>
                <div class="modal-footer">
                    <p v-show="modalState == 'terms'">
                        <strong>
                        The above information is a summary of some of the guidelines regarding Port-Harcourt Electricity Distribution Company Resources.
                        For additional information, please check www.phed.com.ng.
                        </strong> 
                    </p>
                    <button type="submit" class="btn btn-danger" v-show="modalState == 'flow'">CONTINUE</button>
                </div>
               
            </div>
        </div>
    </div>
   
</div>

</template>



<script>
    import {RotateSquare5} from 'vue-loading-spinner'
    import Swal from 'sweetalert2'

    export default {
        created(){
            this.details.official_email = this.email
            this.details.staff_id = this.staff_id
            this.details.first_name = this.first_name
            this.details.last_name = this.last_name
            this.details.other_name = this.other_name
            setTimeout(()=> {
                this.componentLoaded = true
            }, 2000)
        },
        mounted(){
            this.getCurrentRequest();
            if(this.request_type == "sage"){
                this.title = "Sage X3 ERP Access Form"
                this.type = "Sage X3 ERP"
            }
            if(this.request_type == "dl_enhance"){
                this.title = "DLEnhance Access Form"
                this.type = "DLEnhance"
            }
           
        },
        components: {
            RotateSquare5
        },
        props: {
            email: {
                type: String,
                required: true
            },
            staff_id: {
                type: String,
                required: true
            },
            first_name: {
                type: String,
                required: true
            },
            last_name: {
                type: String,
                required: true
            },
            request_type: {
                type: String,
                required: true
            },
            other_name: {
                type: String,
                required: true
            }
        },
        data() {
            return{
                details: {
                    role: [],
                    access_level: [],
                    hr_module: [],
                    finance_module: [],
                    accepted: false,
                },
                valErrors: [],
                isLoading: false,
                componentLoaded: false,
                staffTypes: ["Vendor", "PHEDC Staff", "Contract Staff", "Others"],
                accessLevels: ["Add", "View", "Edit", "Others"],
                roles: ["Customer Care", "Finance", "Billing", "Internal Audit", "Management"],
                hrModule: ["Personnel Mgt. and Payroll", "Loan Management", "Training", "Employee Self Service"],
                financeModule: ["General Ledger", "Account Payable", "Account Receivable", "Fixed Asset", "Budgeting"],
                currentRequestStatus: '',
                remarks: '',
                modalState: '',
                title: '',
                type: ""
            }
        },
        methods: {
            openModal(state){
                this.modalState = state
                $('#terms').modal('show');               
            },
            initiateSubmit(){
                //this.loadingAlert()
                $('#dlenhanceform').on('submit')
            },
            verifyDetails(){
                if(!this.details.accepted){
                  this.errorAlert("Please accept the Terms and Conditions to continue", "")
                }
                else if(this.details.access_level.length < 1){
                    this.errorAlert("Access level field is required", "")
                }
                else if(this.request_type == 'dl_enhance' && this.details.role.length < 1){
                    this.errorAlert("Role level field is required", "")
                }
                else if(this.request_type == 'sage' && this.details.hr_module.length < 1 && this.details.finance_module < 1){
                   this.errorAlert("You didn't select any module", "Select either a HR or FINANCE module") 
                }
                else{

                    let t = "<p>"
                    t +=  "1. On submission, the form is sent your HOD for approval<br/>"
                    t +=   "2. After the HOD approval, it is sent to the AUDIT for approval<br/>"
                    t +=  "3. After which it is forwarded to the IT Department"
                    t +=  "</p> "  
                    if(this.request_type == 'sage'){
                        t+= "<p>"
                        t += "Approval will be required from the FINANCE/HR depending on the sage module selected"
                        t += "</p>"
                    }
                    Swal.fire({
                        title: 'Please verify details were entered correctly',
                        html: t,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Continue!'
                        }).then((result) => {
                        if (result.value) {
                            this.submit()
                        }
                    })
                }
            
            },
            submit(){
                                  
                this.isLoading = true
                this.loadingAlert()
                this.details.request_type = this.request_type
                axios.post('dl_enhance_request', this.details).then((response)=> {
                    console.log(response.data)
                    if(response.status == 200 || response.status == 201){
                            
                            if(response.data.hasOwnProperty('errors')){
                                this.valErrors = response.data.errors;
                                //this.isLoading = false;
                                this.status = "";
                                setTimeout(()=>{
                                    this.errorAlert("It seems you didn't complete the fields correctly.", "Scroll to top of form for more details")
                                }, 2000)
                                                        
                                //Swal.close();
                            }else{  
                                setTimeout(()=>{
                                    this.successAlert("Request submitted successfully", "Redirecting...please wait")                              
                                }, 1000)     
                                setTimeout(()=>{
                                    // window.location.href = "home"  
                                    location.reload()                             
                                }, 3000)        
                            
                            
                            }
                    }
                    else{
                        this.isLoading = false;
                        this.status = "";
                        this.errorAlert('Something went wrong! We couldn\'t submit your details','<a>please refresh or try again later</a>');
                    }
                }).catch((error)=> {
                    this.isLoading = false;
                    this.status = "";
                    this.errorAlert('Something went wrong! Error connecting to the server');
                }) 
            },
            getCurrentRequest(){
                console.log("Get current request");
                axios.get("get_current_request/"+this.request_type).then( response => {
                    console.log(response.data);
                    if(response.data.status == "HOD_DECLINED"){
                        this.currentRequestStatus = "Your current "+ this.type+ " access request was declined by your HOD\n"
                        this.remarks = "HOD remark: " + response.data.hod_comment
                        console.log(this.currentRequestStatus)
                    }
                    if(response.data.status == "AUDIT_DECLINED"){
                        this.currentRequestStatus = "Your current "+ this.type+ " access request was declined by AUDIT"
                        this.remarks = "AUDIT remark: " + response.data.audit_comment
                        console.log(this.currentRequestStatus)
                    }
                    if(response.data.status == "HR_DECLINED"){
                        this.currentRequestStatus = "Your current "+ this.type+ "  access request was declined by AUDIT"
                        this.remarks = "HR remark: " + response.data.audit_comment
                        console.log(this.currentRequestStatus)
                    }
                    if(response.data.status == "FINANCE_DECLINED"){
                        this.currentRequestStatus = "Your current "+ this.type+ "  access request was declined by AUDIT"
                        this.remarks = "FINANCE remark: " + response.data.audit_comment
                        console.log(this.currentRequestStatus)
                    }
                    if(response.data.status == "TO_HOD"){
                        this.currentRequestStatus = "Your current "+ this.type+ "  access request is with your HOD for approval"
                    }
                    if(response.data.status == "TO_HR"){
                        this.currentRequestStatus = "Your current "+ this.type+ "  access request is with HR for approval"
                    }
                    if(response.data.status == "TO_FINANCE"){
                        this.currentRequestStatus = "Your current "+ this.type+ "  access request is with FINANCE for approval"
                    }
                    if(response.data.status == "TO_AUDIT"){
                        this.currentRequestStatus = "Your current DLEnhance access request is with AUDIT for approval"
                    }
                   
                    if(response.data.status == "TO_IT"){
                        if(this.request_type == 'sage'){
                            this.currentRequestStatus = "Your current DLEnhance access request has being approved by the HOD, FINANCE, HCM and AUDIT"
                        }
                        else{
                            this.currentRequestStatus = "Your current DLEnhance access request has being approved by the HOD and AUDIT"
                        }
                        
                        this.remarks = "It is now been reviewed by the IT team"
                    }
                }).catch(error => {
                    this.errorAlert("Something went wrong", "couldn't connect to the server")
                })
            },
            loadingAlert(){
                Swal.fire({
                    html: '<i class="fa fa-circle-o-notch fa-spin text-primary fa-5x"></i>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    footer: 'processing request...please wait'
                })
            },
            errorAlert(text, footer){
                Swal.fire({
                    icon: 'error',
                    position: 'center',
                    title: 'Oops...',
                    text: text,
                    showConfirmButton: true,
                    footer: footer
                })
            },
            successAlert(text, footer){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: "Congrats...",
                    text: text,
                    showConfirmButton: false,
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
            }
        }
    } 
</script>

<style scoped>
    #add{
        font-size: 12px;
        line-height: 1.2;
    }
    .des{
        font-size: 12px;
        line-height: 1.4;
        margin-bottom: 1px;
    }
    hr{
        margin-top: 2px;
        margin-bottom: 2px;
    }
</style>