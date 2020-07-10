<template>

<div>

    <div class="row justify-content-center" v-show="!componentLoaded">
        <div class="col-md-6 text-center" style="margin-top:10%">
            <rotate-square-5 :size="'120px'"></rotate-square-5>
        </div>
    </div>

    <div class="mh-fullscreen bg-img center-vh p-20 bg-primary" v-show="componentLoaded">
        <canvas class="constellation"></canvas>

        <div class="card card-shadowed p-20 w-400 mb-0" style="max-width: 100%">

        <div class="text-center">
                <a href="."><img :src="'./images/PHEDLogo.jpg'" alt="phed logo"  style="width:100px;height:100px"/></a>
        </div>
        <h5 class="text-uppercase text-center">Create Account</h5>
        
            <template v-if="valErrors.length > 0">
                    <ul class="text-center">
                        <li class="text-danger" v-for="(err, index) in valErrors" :key=index><strong>{{ err }}</strong></li>
                    </ul>             
            </template>


        <form @submit.prevent="submit()">
                            
            <div class="form-group">
            <input id="staff_id" type="text" class="form-control" placeholder="Staff ID" required autocomplete="name" v-model="staff_id" autofocus>
            </div>
            
            <div class="form-group">
            <input id="email" type="email" class="form-control" required autocomplete="email" v-model="email" placeholder="Email Address">
            </div>
    
            <div class="form-group">
            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" v-model="password" placeholder="Password">
            </div>

            <div class="form-group">  
            <input id="password-confirm" type="password" class="form-control" required autocomplete="new-password" v-model="confirm_password" placeholder="Confirm Password">
            </div>    
            <br>

            <div class="form-group text-center justify-content-center">
                <button class="btn btn-primary">
                    Create Account
                </button>        
            </div>

            <p class="text-center text-muted fs-13">Already have an account? <a href="login"> Login</a></p>

        </form>
        
        </div>
    </div>
</div>
</template>

<script>

    import {RotateSquare5} from 'vue-loading-spinner'
    import Swal from 'sweetalert2'

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            setTimeout(() => {
                this.componentLoaded = true
            }, 2000)
        },
        components: {
            RotateSquare5
        },
        data(){
            return {
                staff_id: "",
                email: "",
                name: "",
                password: "",
                confirm_password: "",
                staffDetails: {},
                valErrors: [],
                componentLoaded: false
            }
        },
        methods: {
            
            submit(){

                if(this.password != this.confirm_password){
                    this.errorAlert("Operation failed", "Password do not match")
                    this.valErrors = [];
                }
                else{

                    this.email = this.email.toLowerCase()
                    this.loadingAlert("creating your account...please wait")
                    let regDetails = {
                            "email" : this.email, 
                            "name": this.name,
                            "staff_id": this.staff_id,
                            "password" : this.password,
                    }

                    this.register(regDetails)
                }
                
               
            },
            /*get_staff_details(email, staff_id){

                this.status = "VERIFYING EMAIL/ID..."

                let data = {"email": email, "staffId": staff_id}
                axios.post('get_staff_details', data).then((response) => {
                    
                   if(response.status == 200 || response.status == 201){
                        
                        this.staffDetails = response.data
                        this.name = response.data.Staff_Surname + " " + response.data.Staff_Name;
                        //console.log("staff details " + this.staffDetails.Staff_Surname)
                            //console.log(response)
                        let regDetails = {
                            "email" : this.email, 
                            "name": this.name,
                            "staff_id": this.staff_id,
                            "password" : this.password,
                        }

                        this.register(regDetails)
                    }
                    else{
                        this.errMsg = "Staff Id and Staff Email combination not found"
                        this.isLoading = false;
                        this.status = "";
                    } 

                }).catch((error) => {
                    //console.log(error);
                    this.errMsg = "Ooops...couldn't connect to server. Please refresh or try again later"
                    this.isLoading = false;
                    this.status = "";
                });
            }, */
            register(request){
                axios.post('register', request).then((response) => {                 
                   if(response.status == 200 || response.status == 201){                       

                        if(response.data.hasOwnProperty('errors')){
                             setTimeout(()=>{
                                this.errorAlert("Login Failed.", this.valErrors[0])
                                 this.valErrors = response.data.errors;
                            }, 2000)
                        }else{    
                             setTimeout(()=>{
                                this.successAlert("Account Created successfully.", "", true)
                            }, 2000)
                            setTimeout(()=>{
                                window.location.href = "login"
                            }, 5000)              
                            
                        }
                   }
                   else{
                        setTimeout(()=>{
                            this.errorAlert("An error occured", " Please refresh or try again later")
                        }, 2000)
                   }
                }).catch((error) => {
                    setTimeout(()=>{
                        this.errorAlert("We couldn't create your account", "Error connecting to the server",)
                    }, 2000) 
                });
            },
            /*vue_submit(request){
                this.status = "UPDATING STAFF DETAILS..."
                 axios.post('vue_submit', request).then((response) => {                 
                   if(response.status == 200 || response.status == 201){
                       //this.isLoading = false
                       this.status = "SUCCESS...REDIRECTING"
                       window.location.href = "login"
                   }
                   else{
                       this.errMsg = "Aiish..unable to update staff details"
                   }
                }).catch((error) => {
                    this.errMsg = "Aiish..couldn't create account. Error connecting to the server"
                    this.isLoading = false;
                    this.status = "";
                });
            },*/
            loadingAlert(footer){
                Swal.fire({
                    html: '<i class="fa fa-circle-o-notch fa-spin text-primary fa-5x"></i>',
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
                    position: 'top-end',
                    icon: 'success',
                    text: text,
                    toast: toast,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    width: 300,
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
