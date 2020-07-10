<template>

<div>

    <div class="row justify-content-center" v-show="!componentLoaded">
        <div class="col-md-6 text-center" style="margin-top:10%">
            <rotate-square-5 :size="'120px'"></rotate-square-5>
        </div>
    </div>

    <section class="mh-fullscreen bg-img center-vh p-20 bg-primary" v-show="componentLoaded">
        <canvas class="constellation"></canvas>
        <div class="card card-shadowed p-20 w-400 mb-0 elevation-4" style="max-width: 100%">

            <div class="text-center">
                <a href='.'><img :src="'./images/PHEDLogo.jpg'" alt="phed logo"  style="width:100px;height:100px"/></a>
            </div>

            <h5 class="text-uppercase text-center">Login</h5>

            <template v-if="valErrors.length > 0">
                <ul>
                    <li class="text-danger" v-for="(err, index) in valErrors" :key=index><strong>{{ err }}</strong></li>
                </ul>
            </template>

            <form @submit.prevent="submit">

                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email Address" name="email" v-model="email" autocomplete="email" autofocus required>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" v-model="password" autocomplete="current-password" required>
                </div>

                <div class="form-group flexbox py-10">
                <label class="custom-control custom-checkbox" type="checkbox" name="remember">
                    <input type="checkbox" class="custom-control-input" v-model="remember" checked>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Remember me</span>
                </label>

                <a class="text-muted hover-primary fs-13" href="password/reset">
                   Forgot Your Password
                </a>

                </div>

                <div class="form-group">
                <button class="btn btn-bold btn-block btn-primary" type="submit">Login</button>
                </div>
            </form>


            <hr class="w-30">
            <p class="text-center text-muted fs-13 mt-20">Don't have an account? <a :href="'./register'">Create Account</a></p>
        </div>

    </section>

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
                email: "",
                password: "",
                remember: true,
                valErrors: [],
                componentLoaded: false
            }
        },
        methods: {

            submit(){


                this.loadingAlert("Verifying credentials...please wait",)
                this.email = this.email.toLowerCase()
                let loginDetails = {
                    "email" : this.email,
                    "password" : this.password,
                }

                let apiLoginDetails = {
                    "username" : this.email,
                    "password" : this.password,
                }

                //this.login(loginDetails)
                this.apiLogin(apiLoginDetails);
            },

            apiLogin(request){
              console.log("api login");
              axios.post('api_login', request).then((response) => {
                 if(response.status == 200 || response.status == 201){

                     console.log(response.data);

                     if(response.data.Status == "SUCCESSFUL"){
                       console.log("successful");
                       setTimeout(()=>{
                           this.successAlert("Login Successful.", "Redirecting to dashboard", true)
                       }, 2000)
                       setTimeout(()=>{
                           window.location.href = "dashboard"
                       }, 5000)

                     }
                     else{
                       this.errorAlert("Login Failed.", response.data.Message);
                     }
                 }
                 else{
                      setTimeout(()=>{
                          this.errorAlert("An error occured", " Please refresh or try again later")
                      }, 2000)

                 }
              }).catch((error) => {

                  var errMsg = "Error Connecting to the server";

                  if (error.response) {

                    console.log("Actual Response Error: " + error.response.data.errors[0]); //actual error
                    console.log("Formatted Error Response: "+ error.response.data.errors[1]); //formatted error

                    errMsg = error.response.data.errors[1];

                    setTimeout(()=>{
                        this.errorAlert("Login Unsuccessful", errMsg,)
                    }, 2000)
                  }

              });
            },

            login(request){
                axios.post('login', request).then((response) => {
                   if(response.status == 200 || response.status == 201){

                        if(response.data.hasOwnProperty('errors')){
                            setTimeout(()=>{
                                this.errorAlert("Login Failed.", this.valErrors[0])
                                 this.valErrors = response.data.errors;
                            }, 2000)
                        }else{
                            //console.log(response)
                            setTimeout(()=>{
                                this.successAlert("Login Successful.", "Redirecting to dashboard", true)
                            }, 2000)
                            setTimeout(()=>{
                                window.location.href = "dashboard"
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
                        this.errorAlert("Login Failed", "Error connecting to the server",)
                    }, 2000)
                });
            },
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
