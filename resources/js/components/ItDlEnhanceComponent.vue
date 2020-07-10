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
                    
                <div class="col-12 col-md-8 mt-25">
                    <h6><strong>{{title}} Access Request</strong></h6>
                </div>
                 <div class="col-12 col-md-4 mt-25">
                    <form>
                        <select class="form-control" @change="getRequests($event)">
                            <option value="ALL">ALL REQUESTS</option>
                            <option value="APPROVED">IT APPROVAL REQUIRED</option>
                            <option value="TO_HOD">HOD APPROVAL REQUIRED</option>
                            <option value="TO_AUDIT">AUDIT APPROVAL REQUIRED</option>
                            <option value="TO_HR" v-show="request_type == 'sage'">HR APPROVAL REQUIRED</option>
                            <option value="TO_FINANCE" v-show="request_type == 'sage'">FINANCE APPROVALS REQUIRED</option>                                                   
                            <option value="HOD_DECLINED">HOD DECLINED</option>
                            <option value="AUDIT_DECLINED">AUDIT DECLINED</option>                          
                            <option value="HR_DECLINED" v-show="request_type == 'sage'">HR DECLINED</option>
                            <option value="FINANCE_DECLINED" v-show="request_type == 'sage'">FINANCE DECLINED</option>   
                            <option value="TO_CREATE"> APPROVED BUT YET TO BE CREATED</option>   
                            <option value="CREATED">CREATED</option>    
                        </select>
                    </form>
                </div>
                
            </div>

            <div class="row mx-1 mb-10 justify-content-center elevation-3">
                <div class="col-md-12 text-center justify-content-center">
                     Showing Results for <strong>{{searchQuery}}</strong>
                </div>
            </div>
           
            <!--<div class="row mb-10">
                <div class="col-md-12 text-center"> Show Result for <strong> XXXXX</strong></div>
            </div> -->
           
            <!-- <div class="row mb-10">
                
                <div class="col-md-8">
                    <form method="post" action="/download-receipt"> 
                        
                        <select name="ibc">
                            <option value="All">All IBCs</option>
                            
                            <option>Zones</option>
                            
                        </select>
                        <button type="submit" name="type" value="pdf" class="btn btn-sm btn-round" title="download PDF format">
                            <i class="fa fa-file-pdf-o fa-2x text-danger"></i>
                        </button>
                        <button type="submit" name="type" value="excel" class="btn btn-sm btn-round" title="download EXCEL format">
                            <i class="fa fa-file-excel-o fa-2x text-primary"></i>
                        </button>
                    </form>
                </div> 
                <div class="col-md-4 text-right">
                    <form method="post" action="sort"> 
                        
                        <select name="ibc">
                            <option value="All">All IBCs</option>
                            
                            <option>Zones</option>
                            
                        </select>
                        <button type="submit" class="btn btn-sm btn-round btn-primary">sort</button>
                    </form>
                </div>
                    
            </div>
            -->
            <div class="row text-center" v-show="activeRequests.length < 1">
                <div class="col-md-10"><h3 class="text-center text-danger"> {{msg}}</h3></div>
            </div>
            <div class="row" v-show="activeRequests.length > 0">
                <div class="col-md-12">
                
                        <div class="table-responsive"> 

                            <table class="table table-bordered" id="user_table" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th><strong>S/N</strong></th>
                                        <th><strong>STAFF NAME</strong> </th>
                                        <th><strong>STAFF ID</strong></th>
                                        <th><strong>DESIGNATION</strong></th>
                                        <th><strong>STATUS</strong></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                        <tr v-for="(request, index) in activeRequests" :key="index" class="text-center">
                                            <td>
                                                {{index = index + 1}}
                                            </td>
                                            <td> 
                                                <a :href="'../../requests/'+request_type+'/'+request.id+'/'+request.staff_id+'/?approval=it'">
                                                     {{request.name}}
                                                </a>
                                              
                                             </td>
                                            <td> {{request.staff_id}}</td>
                                            <td>
                                    
                                                {{request.designation}}
                                            </td>
                                            <td>
                                                <!-- to hod -->
                                                <p v-show="request.status == 'TO_HOD'">
                                                    SUMMITED TO HOD
                                                </p>
                                                <p v-show="request.status == 'TO_AUDIT'">
                                                    SUBMITED TO AUDIT
                                                </p>
                                                <p v-show="request.status == 'TO_IT'">
                                                    SUBMITTED TO IT
                                                </p>
                                                <p v-show="request.status == 'TO_HR'">
                                                    SUBMITTED TO HR
                                                </p>
                                                <p v-show="request.status == 'TO_FINANCE'">
                                                    SUBMITTED TO FINANCE
                                                </p>
                                                <p v-show="request.status == 'TO_CREATE'">
                                                    APPROVED BY IT
                                                </p>
                                                <!-- declines -->
                                                <p v-show="request.status == 'HOD_DECLINED'">
                                                    DECLINED BY HOD
                                                </p>
                                                <p v-show="request.status == 'AUDIT_DECLINED'">
                                                    DECLINED BY AUDIT
                                                </p>                                             
                                                 <p v-show="request.status == 'FINANCE_DECLINED'">
                                                    DECLINED BY FINANCE
                                                </p>
                                                 <p v-show="request.status == 'HR_DECLINED'">
                                                    DECLINED BY HR
                                                </p>
                                                <p v-show="request.status == 'IT_DECLINED'">
                                                    DECLINED BY IT
                                                </p>
                                                <p v-show="request.status == 'TO_CREATE'">
                                                    YET TO BE CREATED
                                                </p>
                                                <p v-show="request.status == 'CREATED'">
                                                    CREATED
                                                </p>
                                            </td>

                                            <!--<td>
                                            
                                            
                                            <a class="btn btn-primary" href="route('reminder', ['id' => $employee->account_id])" title="send reminder">
                                                <i class="fa fa-bell-o"></i>
                                            </a>
                                    
                                            
                                        
                                            <a class="btn btn-danger" href="download/$employee->staff_id" title="download report">
                                                <i class="fa fa-download"></i>
                                            </a>
                                                                                               
                                            
                                            <a class="btn btn-success" href="proof/$employee->proof" title="download proof"><i class='fa fa-file-text-o'></i> </a>
                                                
                                               
                                            </td> -->
                                        </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="text-center">
                                        <td colspan='8<br/>'>
                                           PHED STAFF FORMS                            
                                        </td>
                                    
                                    </tr>
                                </tfoot>
                                
                            </table>
                        
                        </div>
                    </div>

            </div>


            <div class="modal fade" id="newAppraisal" ref="m" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger" id="exampleModalLabel">Create New Appraisal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="createNewAppraisal">
                            
                            <div class="modal-body">
                                <input type="number" class="form-control mb-3" placeholder="Year" v-model="newAppraisal.year" required/>
                                <input type="text" class="form-control mb-3" placeholder="Appraisal Title" v-model="newAppraisal.title" required/>
                                <label> Status</label>
                                <select class="form-control" v-model="newAppraisal.status" required>
                                    <option value=""></option>
                                    <option>KPI Setting</option>
                                    <option>Open</option>
                                    <option>Closed</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
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
    created(){
        setTimeout(() => {
            this.componentLoaded = true
        }, 2000)

    },
    mounted(){
        if(this.request_type == 'sage'){
            this.title = "Sage X3 ERP"
        }
        else{
            this.title = "DLEnhance"
        }
        this.getAllRequests()
    },
    props:{
        request_type: {
            type: String,
            required: true
        }
    },
    components: {
        RotateSquare5
    },
    data(){
        return {
            newAppraisal : {},
            componentLoaded: false,
            activeRequests: [],
            msg: "",
            details: {},
            title: "",
            searchQuery: "Total Requests"
        }
    },
    methods: {
        
        //create new appraisal
        getRequests(){ 
            console.log(event.target.value)
            let query = event.target.value;

            this.loadingAlert()
            axios.get(this.request_type+'/'+query).then(res => {
                if(res.status == 200 || res.status == 201){

                    console.log(res.data)
                    setTimeout(()=>{
                        this.activeRequests = res.data
                        this.activeRequests.length < 1 ? this.infoAlert("No requests found", "") : Swal.close()
                        this.msg = "No requests found"

                        if(query == "ALL"){this.searchQuery = "ALL REQUESTS"}
                        if(query == "APPROVED"){this.searchQuery = "IT APPROVAL REQUIRED"}
                        if(query == "TO_HOD"){this.searchQuery = "HOD APPROVAL REQUIRED"}
                        if(query == "TO_AUDIT"){this.searchQuery = "AUDIT APPROVAL REQUIRED"}
                        if(query == "TO_HR"){this.searchQuery = "HR APPROVAL REQUIRED"}
                        if(query == "TO_FINANCE"){this.searchQuery = "FINANCE DECLINED"}
                        if(query == "HOD_DECLINED"){this.searchQuery = "HOD DECLINED"}
                        if(query == "AUDIT_DECLINED"){this.searchQuery = "AUDIT DECLINED"}
                        if(query == "HR_DECLINED"){this.searchQuery = "HR DECLINED"}
                        if(query == "FINANCE_DECLINED"){this.searchQuery = "FINANCE DECLINED"}
                        if(query == "IT_DECLINED"){this.searchQuery = "IT DECLINED"}
                        if(query == "TO_CREATE"){this.searchQuery = "YET TO BE CREATED"}
                        if(query == "CREATED"){this.searchQuery = "CREATED"}

                    }, 1000)
                                      
                }
                               
            })
            .catch(err => {
                console.log(err)
                this.errorAlert("Something went wrong", "Failed to add new appraisal")
            })
        },
        getAllRequests(){
            axios.get(this.request_type+'/ALL').then(res => {
                if(res.status == 200 || res.status == 201){

                    console.log(res.data)
                    setTimeout(()=>{
                        this.activeRequests = res.data

                        this.msg = "No requests found"
                    }, 1000)
                           
                }
                               
            })
            .catch(err => {
                console.log(err)
                this.errorAlert("Something went wrong", "Failed to add new appraisal")
            })
        },
        showDetails(index){
            this.details = this.activeRequests[0];
            console.log(this.details.staff_id)
            $('#newAppraisal').modal('show')
        },
        loadingAlert(){
            Swal.fire({
                html: '<i class="fa fa-circle-o-notch fa-spin text-primary fa-3x"></i>',
                allowOutsideClick: false,
                showConfirmButton: false,
                footer: 'retrieving requests...please wait'
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
                title: "Ooops....",
                text: text,
                showConfirmButton: true,
                allowOutsideClick: true,
                footer: footer
            })
        },
    }
}


</script>