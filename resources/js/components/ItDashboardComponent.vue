<template>

    <div>

     <div class="row justify-content-center" v-show="!componentLoaded">
        <div class="col-md-6 text-center" style="margin-top:10%">
            <rotate-square5 :size="'120px'"></rotate-square5>
        </div>
    </div>
    <section v-show="componentLoaded">
        <div class="container">
            
            <div class="row my-20">
                    
                <div class="col-12 col-md-12 mt-25">
                    <ul class="nav nav-vertical">
                        <li class="nav-item text-center">
                        <a class="nav-link active" data-toggle="tab" href="#new">
                            <h6> Dashboard</h6>
                        </a>
                        </li>           
                    </ul>
                </div>
            </div>

            <div class="row mb-10 elevation-3">
                <div class="col-md-12 text-center mb-10"><p>ACCESS REQUESTS</p></div>
                <div class="col-md-3 text-center"> 
                    DLEnhance
                    <strong><a href="it/dl_enhance">View Details</a></strong>
                </div>
                <div class="col-md-3 text-center"> 
                    Sage 
                   <strong><a href="it/sage">View Details</a></strong>
                </div>
                <div class="col-md-3 text-center">
                     VPN
                     <strong><a href="#" @click="comingSoon">View Details</a></strong>
                </div>
                <div class="col-md-3 text-center"> 
                    Wifi 
                    <strong><a href="#" @click="comingSoon">View Details</a></strong>
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
    created(){
        setTimeout(()=> {
            this.componentLoaded = true
        }, 2000)
     },
    components: {
        RotateSquare5
    },
    data(){
        return {
            newAppraisal : {},
            componentLoaded: false,
        }
    },
    methods: {
        
        //create new appraisal
        createNewAppraisal(){ 
            //$('#newAppraisal').modal('toggle');          
            console.log(this.newAppraisal.year)        
            this.loadingAlert()
            let data = {
                'year': this.newAppraisal.year,
                'title': this.newAppraisal.title,
                'status': this.newAppraisal.status
            }
            axios.post('create_new_appraisal', data).then(res => {
                console.log(res.data);
                if(res.status == 200 || res.status == 201){
                    if(res.data == "exists"){
                        this.errorAlert("Couldn't add appraisal", "An ongoing appraisal with status '" + this.newAppraisal.status + "' already exists");
                    }
                    else{
                        
                        this.successAlert("Appraisal created successfully", res.data)
                        this.newAppraisal.year = ""
                        this.newAppraisal.title = ""
                        this.newAppraisal.status = ""
                        
                    }
                }
                               
                //location.reload()
            })
            .catch(err => {
                console.log(err)
                this.errorAlert("Something went wrong", "Failed to add new appraisal")
            })
        },
        comingSoon(){
            this.infoAlert("","")
        },
        loadingAlert(){
            Swal.fire({
                html: '<i class="fa fa-circle-o-notch fa-spin text-primary fa-2x"></i>',
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
                showConfirmButton: true,
                allowOutsideClick: false,
                footer: footer
            })
        },
        infoAlert(text, footer){
            Swal.fire({
                position: 'center',
                icon: 'info',
                title: "Coming Soon",
                text: text,
                showConfirmButton: false,
                allowOutsideClick: true,
                footer: footer
            })
        },
    }
}


</script>