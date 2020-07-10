<template>
    <div >
    <div v-show="isLoading" style="height=100vh">       
        <rotate-square5 v-show="isLoading" :size="'120px'" :color="'#025aa5'"></rotate-square5>       
    </div>
    <div class="row justify-content-center mx-1 mb-5" v-show="!isLoading">
        <div class="col-md-12 text-center my-1">
            <h4 class="text-primary my-5"><strong> 2019 APPRAISAL PROFILE DATA</strong> </h4>
        </div>
       
        <div class="col-md-5 elevation-2 mr-2">
            <div class="row px-3 mb-2">
               
                <div class="col-md-12">
                    <div class="divider text-primary mb-2"><strong>PERSONAL INFORMATION</strong></div>
                     
                </div> 
            </div>
            <div class="row px-3 mt-4">
                <div class="col-md-6">
                <div class="form-group">
                        <label for="staffId">Staff ID<span class="text-danger">*</span></label>
                        <p>{{staff.staff_id}}</p>
                    </div>
                </div> 
                <div class="col-md-6">
                <div class="form-group">
                        <label for="designation">Designation<span class="text-danger">*</span></label>
                        <p>{{staff.designation}}</p>
                    </div>
                </div>     
            </div>

            <div class="row px-3">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="firstName">Name<span class="text-danger">*</span></label>
                        <p>{{staff.name}}</p>
                    </div>
                </div>
               
            </div>
            <div class="row px-3">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="officer_email">Official Email<span class="text-danger">*</span></label>
                         <p>{{staff.email}}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="haq">Higest Academic Qualification<span class="text-danger">*</span></label>
                        <p>{{staff.haq}}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="doe">Date of Employment in PHED<span class="text-danger">*</span></label>
                         <p>{{staff.doe}}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ibc">IBC<span class="text-danger">*</span></label>
                         <p>{{staff.ibc}}</p>
                    </div>
                </div>
            </div>
        
        </div>
  
        <div class="col-md-5 elevation-2">
            <div class="row px-3 mb-1">
                <div class="col-md-12">
                <div class="divider text-primary"><strong>APPRIASER'S INFORMATION</strong></div>
                </div> 
            </div>
            <div class="row px-3">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="firstName">Name<span class="text-danger">*</span></label>
                         <p>{{supervisor.appraiser_name}}</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="lastName">Email<span class="text-danger">*</span></label>
                         <p>{{supervisor.appraiser_email}}</p>
                    </div>
                </div>
            </div>
            <div class="row px-3 mb-1">
                <div class="col-md-12">
                    <div class="divider text-primary"><strong>REVIEWER'S INFORMATION</strong></div>
                </div> 
            </div>
            <div class="row px-3">       
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="firstName">Name<span class="text-danger">*</span></label>
                        <p>{{supervisor.reviewer_name}}</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="lastName">Email<span class="text-danger">*</span></label>
                         <p>{{supervisor.reviewer_email}}</p>
                    </div>
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
    components: {
      RotateSquare5
    },
    props:{
        staff_id: {
            type: String,
            required: true
        }
    },
    data(){
        return {
            staff: {},
            supervisor: {},
            isLoading: true,
            errMessage: ""
        }
    },
    mounted(){
        console.log("profile mounted")
        this.get_staff_details()
    },
    methods:{
        get_staff_details(){
            axios.get('profile/'+this.staff_id, this.staff_id).then((response) => {                 
                if(response.status == 200 || response.status == 201){
                   //console.log(response.data.supervisor)
                   //console.log(response.data.employee)

                    if(response.data.employee == null && response.data.supervisor == null){
                        setTimeout(() => {
                            this.isLoading = false;
                            this.infoAlert("Profile details not found", "It seems you haven't completed appraisal report form",
                             "<a href='../home'>Click here to get started</a>")
                        }, 2000)

                    }
                    else{
                        this.staff = response.data.employee
                        this.supervisor = response.data.supervisor
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 2000)
                    }
                  
                }
                else{
                   this.errorAlert("Couldn't retrieve profile", "please refresh or try again later")
                }
            }).catch((error) => {
                this.isLoading = false
               this.errorAlert("500 Error", "We couldn't connect to the server")
            });
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
        infoAlert(title, text, footer){
                 Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: title,
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
   .cc{
        width: 200px;
        height: 200px;
        font-size: 200px;
        position: absolute;
        top: 50%;
    }

</style>
