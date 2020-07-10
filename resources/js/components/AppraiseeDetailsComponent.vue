<template>


<div class="container">
    <div class="row justify-content-center" v-show="!componentLoaded">
        <div class="col-md-6 text-center" style="margin-top:10%">
            <rotate-square5 :size="'120px'"></rotate-square5>
        </div>
    </div>
    <div class="row justify-content-center" v-show="componentLoaded">
        <div class="col-md-6">
   
            <form method="post" action="appraisal_details" class="bg-white px-30 elevation-4" @submit.prevent="verifyDetails">
                
                <div class="row px-3">
                    <div class="col-md-12 text-center my-10">
                        <h4 class="text-primary mt-5 mb-3"><strong> 2019 Performance Appraisal Report</strong> </h4>

                        <template v-if="valErrors.length > 0">
                            <ul class="mt-3 text-left">
                                <li class="text-danger" v-for="(err, index) in valErrors" :key=index>{{ err }}</li>
                            </ul>              
                        </template>
                    
                    </div>

                    <div class="col-md-12">
                    <div class="divider text-primary mb-2"><strong>PERSONAL INFORMATION</strong></div>
                    </div> 
                </div>
                <div class="row px-3">
                    <div class="col-md-6">
                    <div class="form-group">
                            <label for="staffId">Staff ID<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="staffId" v-model="details.staff_id" readonly>
                        </div>
                    </div> 
                    <div class="col-md-6">
                    <div class="form-group">
                            <label for="designation">Designation<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="designation" v-model="details.designation">
                        </div>
                    </div>     
                </div>

                <div class="row px-3">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="firstName">First Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="firstName" v-model="details.first_name" :readonly="details.first_name != ''">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="middleName">Middle Name</label>
                            <input type="text" class="form-control form-control-sm" id="middleName" v-model="details.middle_name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lastName">Last Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="lastName" v-model="details.last_name" :readonly="details.last_name != ''">
                        </div>
                    </div>
                </div>
                <div class="row px-3">
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="officer_email">Official Email<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="firstName" v-model="details.official_email" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="haq">Higest Academic Qualification<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="middleName" v-model="details.haq">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="doe">Date of Employment in PHED<span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" id="lastName" v-model="details.doe">
                        </div>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-12">
                    <div class="divider text-primary"><strong>APPRIASER'S INFORMATION</strong></div>
                    </div> 
                </div>
                <div class="row px-3">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstName">FirstName<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="firstName" v-model="details.appraiser_first_name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="middleName">LastName<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="middleName" v-model="details.appraiser_last_name">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="lastName">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm" v-model="details.appraiser_email">
                        </div>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-12">
                    <div class="divider text-primary"><strong>REVIEWER'S INFORMATION</strong></div>
                    </div> 
                </div>
                <div class="row px-3">       
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstName">FirstName<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="firstName" v-model="details.reviewer_first_name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="middleName">LastName<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="middleName" v-model="details.reviewer_last_name">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="lastName">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm" v-model="details.reviewer_email">
                        </div>
                    </div>
                </div>

                <div class="row px-3 mb-3">       
                    <div class="col-md-12">
                    <div class="divider text-primary"><strong> IBC </strong><span class="text-danger">*</span></div>
                    </div>
                
                    <div class="col-md-6 d-flex" v-for="(ibc, index) in ibcs" :key="index">
                        <div class="mr-2">
                            <input type="radio" class="mx-1" :value="ibc.title" v-model="details.ibc" :id="ibc.title" /><span>{{ibc.title}} </span>
                        </div> 
                    </div> 

                </div>

                <div class="divider class-white"></div>

            <div class="row my-20 justify-content-center mt-5">
                    <button type="submit" name="submit" class="btn btn-round btn-outline-primary mb-10" id="submit">Submit</button>
                </div>

            </form>
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
            setTimeout(()=> {
                this.componentLoaded = true
            }, 2000)
        },
        components: {
            RotateSquare5
        },
        props: {
            ibcs: {
                type: Array,
                required: true
            },
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
            }

        },
        data() {
            return{
                details: {},
                valErrors: [],
                isLoading: false,
                componentLoaded: false,
            }
        },
        methods: {
            verifyDetails(){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this action!",
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
              this.isLoading = true
              this.loadingAlert()
              axios.post('appraisal_details', this.details).then((response)=> {
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
                                this.successAlert("You details have been saved", "Redirecting...please wait")                              
                            }, 2000)     
                             setTimeout(()=>{
                                 window.location.href = "home"                               
                            }, 5000)        
                           
                           
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
            loadingAlert(){
                Swal.fire({
                    html: '<i class="fa fa-circle-o-notch fa-spin text-primary fa-5x"></i>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    footer: 'submitting your details...please wait'
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
                    title: "Yeeeh...",
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