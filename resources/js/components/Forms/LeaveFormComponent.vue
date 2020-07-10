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
                            <strong>LEAVE REQUEST FORM</strong>
                        </h5>
                        <p id="add">
                            <strong>Port-Harcourt Electricity Distribution Company</strong><br/>
                            1 Moscow Road, Port Harcourt<br/>
                          <br/>
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
                <p class="des text-primary">
                    <strong>SECTION A: EMPLOYEE DETAILS </strong>
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
                            <input type="text" class="form-control form-control-sm" v-model="details.other_name" :readonly="details.other_name != ''">
                        </div>
                    </div>

                    <!-- staff id -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="staffId">Staff ID</label>
                            <input type="text" class="form-control form-control-sm" id="staffId" v-model="details.staff_id" readonly>
                        </div>
                    </div>

                    <!-- official email -->
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="officer_email">Official Email<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="firstName" v-model="details.official_email" readonly>
                        </div>
                    </div>

                    <!-- job title -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="designation">Job Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="designation" v-model="details.designation">
                        </div>
                    </div>


                    <!-- Staff Type -->
                    <!--<div class="col-md-4">
                        <div class="form-group">
                            <label for="officer_email">Staff type<span class="text-danger">*</span></label><br/>
                            <select v-model="details.staff_type">
                                <option v-for="(staffType, index) in staffTypes" :key="index">{{staffType}}</option>
                            </select>
                        </div>
                    </div> -->

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lastName">Department<span class="text-danger"></span></label>
                            <input type="text" class="form-control form-control-sm" v-model="details.department">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lastName">Location<span class="text-danger"></span></label>
                            <input type="text" class="form-control form-control-sm" v-model="details.location">
                        </div>
                    </div>

                    <!-- brief job description -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="officer_email">Reason(s) for absence<span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" v-model="details.reason_for_absence"></textarea>
                        </div>
                    </div>

                     <div class="col-md-12">
                        <div class="form-group">
                            <label for="lastName">Please approve absence from work (specify number of days)<span class="text-danger"></span></label>
                            <input type="number" class="form-control form-control-sm" min="0" max="31" v-model="details.days_of_absence">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lastName">Start Date<span class="text-danger"></span></label>
                            <input type="date" class="form-control form-control-sm" v-model="details.start_date">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lastName">End Date<span class="text-danger"></span></label>
                            <input type="date" class="form-control form-control-sm" v-model="details.end_date">
                        </div>
                    </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="lastName">Resumption<span class="text-danger"></span></label>
                            <input type="date" class="form-control form-control-sm" v-model="details.resumption_date">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="officer_email">Any unused leave?<span class="text-danger">*</span></label><br/>
                            <select v-model="details.unused_year" class="form-control form-control-sm">
                                <option v-for="(unUsedYear, index) in unUsedYears" :key="index">{{unUsedYear}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="lastName">Number of days<span class="text-danger"></span></label>
                            <input type="number" class="form-control form-control-sm" min="1" max="31" v-model="details.unused_days">
                        </div>
                    </div>

                </div>

                <!-- section B: starts -->

                <hr class="divider">
                <p class="des text-primary">
                    <strong>SECTION B: CONTACT DETAILS DURING LEAVE</strong>
                </p>
                <hr class="divider">

                <div class="row">

                    <!-- Residential Address -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="officer_email">Residential Address<span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" v-model="details.residential_address"></textarea>
                        </div>
                    </div>
                    <!--Personal email -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="officer_email">Personal Email<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="firstName" v-model="details.personal_email">
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">Telephone<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="designation" v-model="details.telephone">
                        </div>
                    </div>

                </div>
                <!-- section B: ends -->


                <!-- section C: starts -->

                <hr class="divider">
                <p class="des text-primary">
                    <strong>SECTION C: LEAVE CATEGORY(TICK AS APPROPRIATE)</strong>
                </p>
                <hr class="divider">

                <div class="row my-2">
                  <div class="col-md-4 d-flex" v-for="(lc, index) in leaveCategories" :key="'A-'+index">
                      <div class="mr-2">
                          <input type="checkbox" class="mx-1" :value="lc" v-model="details.leave_categories" /><span class='des'>{{lc}} </span>
                      </div>
                  </div>

                </div>

                <hr class="divider">
                <p class="des text-primary">
                    <strong>SECTION D: HAND OVER MATERIALS (TICK AS APPROPRIATE)</strong>
                </p>
                <hr class="divider">

                <div class="row my-2">
                  <div class="col-md-4 d-flex" v-for="(lc, index) in handOverMaterials" :key="'A-'+index">
                      <div class="mr-2">
                          <input type="checkbox" class="mx-1" :value="lc" v-model="details.hand_over_materials" /><span class='des'>{{lc}} </span>
                      </div>
                  </div>

                </div>

                  <!-- section C: starts -->

                  <hr class="divider">
                  <p class="des text-primary">
                      <strong>SECTION E: REQUIRED EMAILS</strong>
                  </p>
                  <hr class="divider">

                  <div class="row my-3">
                      <!--Relief Email -->
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="officer_email">Relief Officer Email<span class="text-danger">*</span></label>
                              <input type="email" class="form-control form-control-sm" v-model="details.relief_officer_email">
                          </div>
                      </div>

                      <!-- Supervisor Email -->
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="designation">Supervisor Email<span class="text-danger">*</span></label>
                              <input type="email" class="form-control form-control-sm" v-model="details.supervisor_email">
                          </div>
                      </div>

                          <!-- Overall Supervisor Email -->
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="officer_email">Overrall Supervisor Email<span class="text-danger">*</span></label>
                              <input type="email" class="form-control form-control-sm" v-model="details.overall_supervisor_email">
                          </div>
                      </div>

                  </div>
                  <!-- section C: ends -->

                  <div class="row justify-content-center my-2">
                      <button name="submit" class="btn btn-round btn-primary mb-10">
                          Submit FOR APPROVALS
                      </button>

                  </div>

                <!--
                  <hr class="divider">
                  <p class="des text-primary">
                      <strong>SECTION G: RELIEF OFFICER ACKNOWLEDGEMENT</strong>
                  </p>
                  <hr class="divider">

                  <div class="row my-3">
                      <div class="col-md-4 d-flex" v-for="(osr, index) in RecommendationStatus" :key="'A-'+index">
                        <div class="mr-2">
                            <input type="checkbox" class="mx-1" :value="osr" v-model="details.overall_supervisor_recom" /><span class='des'>{{osr}} </span>
                        </div>
                      </div>

                  </div>

                  <hr class="divider my-3">
                  <p class="des text-primary">
                      <strong>SECTION F: SUPERVISOR'S/HOD'S RECOMMENDATION</strong>
                  </p>
                  <hr class="divider">

                    <div class="row my-3">
                        <div class="col-md-6 d-flex" v-for="(osr, index) in RecommendationStatus" :key="'A-'+index">
                            <div class="mr-2">
                                <input type="checkbox" class="mx-1" :value="osr" v-model="details.supervisor_recom" /><span class='des'>{{osr}} </span>
                            </div>
                        </div>
                   </div>


                    <hr class="divider">
                    <p class="des text-primary">
                        <strong>SECTION G: OVERALL SUPERVISOR'S APPROVAL</strong>
                    </p>
                    <hr class="divider">

                    <div class="row my-3">
                        <div class="col-md-6 d-flex" v-for="(osr, index) in RecommendationStatus" :key="'A-'+index">
                          <div class="mr-2">
                              <input type="checkbox" class="mx-1" :value="osr" v-model="details.overall_supervisor_recom" /><span class='des'>{{osr}} </span>
                          </div>
                        </div>
                    </div>

                  -->

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

            this.getStaffDetails();
            //this.getCurrentRequest();
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
                    leave_categories: [],
                    hand_over_materials: [],
                },
                valErrors: [],
                isLoading: false,
                componentLoaded: false,
                unUsedYears: ["2020", "2019", "2018", "2017", "2016", "2015", "2014"],
                RecommendationStatus: ["Recommended", "Not Recommended"],
                leaveCategories: ["Annual", "Casual", "Maternity", "Paternity", "Compassionate", "Examination", "Sick", "Unpaid"],
                handOverMaterials: ["Laptop", "CUG Line", "Documents", "Ladder", "Tools", "Vehicle", "Others"],
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


                console.log("fdsdsf"+this.details.supervisor_email);

                  /*if(this.details.relief_officer_email.trim().length < 1){
                      this.errorAlert("Relief officer email is required", "")
                  }
                  else if(this.details.supervisor_email.trim().length < 1){
                      this.errorAlert("Supervisor email is required", "")
                  }
                  else if(this.details.overall_supervisor_email.trim().length < 1){
                      this.errorAlert("Overall supervisor email is required", "")
                  }
                  else if(this.details.designation.trim().length < 1){
                      this.errorAlert("Staff designation is required", "")
                  }
                  else if(this.details.residential_address.trim().length < 1){
                      this.errorAlert("Residential address is required", "")
                  }
                  else if(this.details.telephone.trim().length < 1){
                      this.errorAlert("Phone number is required", "")
                  }
                  else if(this.details.reason_for_absence.trim().length < 1){
                      this.errorAlert("Reason for absence is required", "")
                  }
                  else if(this.details.days_of_absence.trim().length < 1){
                      this.errorAlert("Number of days of absence is required", "")
                  }
                  else if(this.details.department.trim().length < 1){
                      this.errorAlert("Department is required", "")
                  }

                  */

                    let t = "<p>"
                    t +=  "1. On submission, the form is sent the relief officer for acknowledgement<br/>"
                    t +=   "2. After the relief officer acknowledgement, it is sent to your supervisor for recommendation<br/>"
                    t +=  "3. After your supervisor, it is sent to your overall supervisor for final recommendation"
                    t +=  "</p> "

                  //  let t = "<p></p>";
                    Swal.fire({
                        title: 'Please verify your details were entered correctly',
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


            },
            submit(){

                //this.isLoading = true
                //this.loadingAlert()

                axios.post('submit_leave_request', this.details).then((response)=> {
                    console.log(response.data)
                    if(response.status == 200 || response.status == 201){

                          console.log(response);
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
            getStaffDetails(){
               axios.post("get_staff_details", {"staff_id": this.staff_id}).then(response => {

                   this.details.designation = response.data.designation;
                   this.details.residential_address = response.data.address;
                   this.details.telephone = response.data.phone;
                   this.details.location = response.data.location;
                    console.log(response.data.designation);
               }).catch(error => {
                  console.loge(error.response.data);
               });
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
