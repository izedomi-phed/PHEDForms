<template>
   
<form @submit="submit()">
    <div class="row">
    
    <div class="col-md-12">
        <template v-if="valErrors.length > 0">
            <ul>
                <li class="text-danger" v-for="(err, index) in valErrors" :key=index><strong>{{ err }}</strong></li>
            </ul>             
        </template>
    </div>

    <div class="col-md-12">

        <div class="accordion" id="accordion-1">
           
           <!-- financial performance: starts -->
            <div class="card mb-3">
                <h5 class="card-title">
                    <a data-toggle="collapse" data-parent="#accordion-1" href="#collapse-1-1">* Financial Performance Target and Achievement</a>
                </h5>

                <div id="collapse-1-1" class="collapse in bg-light">
                    <div class="card-block">
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                    <tr class="text-dark">
                                        <th width="40%"> Financial Dimension Task</th>
                                        <th width="20%">Target Planned</th>
                                        <th width="20%">Target Achieved</th>
                                        <th width="15%">Rating by S</th>
                                        <th width="2%">Rating by A</th>
                                        <th width="2%">Rating by R</th>
                                        <th width="1%"></th>
                                    </tr>
                                </thead>


                                <tbody >
                                    <tr v-for="(input,k) in f" :key="k">
                                        <td><input type="text" class="form-control" v-model="input.title"></td>
                                        <td><input type="text" class="form-control" v-model="input.target_planned"></td>
                                        <td><input type="text" class="form-control" v-model="input.target_achieved"></td>
                                        <td>
                                            <select class="form-control" v-model="input.rating_by_self" required>
                                                <option value=""></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" readonly></td>
                                        <td><input type="text" class="form-control" readonly></td>
                                        <td>
                                            <span>
                                                <button class="btn btn-danger btn-sm btn-round" v-show="k || ( !k && f.length > 1)" @click="remove(k, 'fp')">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <button class="btn btn-success btn-sm btn-round" v-show="k == f.length-1" @click="add(k, 'fp')">
                                                <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                                <tfoot>
                        
                                   <!-- <tr>
                                        <td colspan='7'>
                                            <button class="btn btn-sm btn-danger" @click.prevent="add(k)" >
                                                <i class="fa fa-plus"></i>
                                                Add Set Objective
                                            </button>                        
                                        </td>
                                    
                                    </tr> -->
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- financial performance: ends -->
            

            <!-- customer performance form -->
                      
            <div class="card mb-3">
              <h5 class="card-title">
                <a data-toggle="collapse" data-parent="#accordion-1" href="#collapse-1-123">* Customer Performance Target and Achievement</a>
              </h5>

              <div id="collapse-1-123" class="collapse bg-light">
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr class="text-dark">
                                    <th width="40%"> Customer Dimension Task</th>
                                    <th width="20%">Target Planned</th>
                                    <th width="20%">Target Achieved</th>
                                    <th width="15%">Rating by S</th>
                                    <th width="2%">Rating by A</th>
                                    <th width="2%">Rating by R</th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>

                            <tbody >
                                <tr v-for="(input,k) in c" :key="k">
                                    <td><input type="text" class="form-control" v-model="input.title"></td>
                                    <td><input type="text" class="form-control" v-model="input.target_planned"></td>
                                    <td><input type="text" class="form-control" v-model="input.target_achieved"></td>
                                    <td>
                                        <select class="form-control" v-model="input.rating_by_self" required>
                                            <option value=""></option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" readonly></td>
                                    <td><input type="text" class="form-control" readonly></td>
                                    <td>
                                        <span>
                                            <button class="btn btn-danger btn-sm" v-show="k || ( !k && c.length > 1)" @click="remove(k, 'cp')">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button class="btn btn-success btn-sm" v-show="k == c.length-1"  @click="add(k, 'cp')">
                                            <i class="fa fa-plus"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                                
                            </tbody>
                            <tfoot>
                                <!-- <tr>
                                    <td colspan='7'>
                                        <button class="btn btn-sm btn-danger" @click.prevent="add(k)" >
                                            <i class="fa fa-plus"></i>
                                            Add Set Objective
                                        </button>                        
                                    </td>
                                    
                                </tr> -->
                            </tfoot>
                        </table>
                    </div>
                </div>
              </div>
            </div>

            <!-- customer performance form : ends -->


            <!-- process/operation performance : starts -->
                                    
            <div class="card mb-3">
                <h5 class="card-title">
                    <a data-toggle="collapse" data-parent="#accordion-1" href="#collapse-1-4">* Process/Operations Performance Target and Achievement</a>
                </h5>

                <div id="collapse-1-4" class="collapse bg-light">
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                    <tr class="text-dark">
                                        <th width="40%"> Process/Operation Dimension Tasks</th>
                                        <th width="20%">Target Planned</th>
                                        <th width="20%">Target Achieved</th>
                                        <th width="15%">Rating by Self</th>
                                        <th width="2%">Rating by Appraiser</th>
                                        <th width="2%">Rating by Reviewer</th>
                                        <th width="1%"></th>
                                    </tr>
                                </thead>


                                <tbody >
                                    <tr v-for="(input,k) in p" :key="k">
                                        <td><input type="text" class="form-control" v-model="input.title"></td>
                                        <td><input type="text" class="form-control" v-model="input.target_planned"></td>
                                        <td><input type="text" class="form-control" v-model="input.target_achieved"></td>
                                        <td>
                                            <select class="form-control" v-model="input.rating_by_self" required>
                                                <option value=""></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" readonly></td>
                                        <td><input type="text" class="form-control" readonly></td>
                                         <td>
                                            <span>
                                                <button class="btn btn-danger btn-sm" v-show="k || ( !k && p.length > 1)" @click="remove(k, 'pp')">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <button class="btn btn-success btn-sm" v-show="k == p.length-1" @click="add(k, 'pp')">
                                                <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                                <tfoot>
                        
                                    <!-- <tr>
                                        <td colspan='7'>
                                            <button class="btn btn-sm btn-danger" @click.prevent="add(k)" >
                                                <i class="fa fa-plus"></i>
                                                Add Set Objective
                                            </button>                        
                                        </td>
                                    
                                    </tr> -->
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- process/operation performance: ends -->
           
           
           <!-- behavioural performance: starts -->
            <div class="card mb-3">
              <h5 class="card-title">
                <a data-toggle="collapse" data-parent="#accordion-1" href="#collapse-1-3">* Behavioural Attributes (Weightage - 15 %)</a>
              </h5>

              <div id="collapse-1-3" class="collapse bg-light">
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr class="text-dark">
                                    
                                    <th width="60%"> Behaviourial Attributes </th>
                                    <th width="15%">Rating by Self</th>
                                    <th width="5%">Rating by Appraiser</th>
                                    <th width="5%">Rating by Reviewer</th>
                                    <th width="10%"></th>
                                    
                                </tr>
                            </thead>

                            <tbody >
                                <tr v-for="(input,k) in b" :key="k">
                                    <td>
                                        <select class="form-control" v-model="input.title" required>
                                            <option value=""></option>
                                            <option>Interpersonal skill: Willingness to help others, Relation with peers</option>
                                            <option>Communication skill: Thought clarity, Uses data, Ability to influence</option>
                                            <option>Team Spirit: Cooperate with others, Provide guidance and direction to others, Take responsibility and ownership</option>
                                        </select>
                                    </td>
                                     <td>
                                        <select class="form-control" v-model="input.rating_by_self" required>
                                            <option value=""></option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </td>                               
                                    <td><input type="text" class="form-control" readonly></td>
                                    <td><input type="text" class="form-control" readonly></td>
                                    <td>
                                        <span>
                                            <button class="btn btn-danger btn-sm" v-show="k || ( !k && b.length > 1)" @click="remove(k, 'bp')">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button class="btn btn-success btn-sm" v-show="k == b.length-1" @click="add(k, 'bp')">
                                            <i class="fa fa-plus"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                                
                            </tbody>
                            <tfoot>
                    
                                <!-- <tr>
                                        <td colspan='7'>
                                            <button class="btn btn-sm btn-danger" @click.prevent="add(k)" >
                                                <i class="fa fa-plus"></i>
                                                Add Set Objective
                                            </button>                        
                                        </td>
                                    
                                    </tr> -->
                            </tfoot>
                        </table>
                    </div>
                </div>
              </div>
            </div>
            <!-- behavioural performance: ends -->
           

            <!-- tranining performance: starts -->      
            <div class="card mb-3">
              <h5 class="card-title">
                <a data-toggle="collapse" data-parent="#accordion-1" href="#collapse-1-5">* Training (Weightage - 5%)</a>
              </h5>

              <div id="collapse-1-5" class="collapse bg-light">
                <div class="card-block">
                    <div class="table-responsive">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                    <tr class="text-dark">
                                        <th width="40%"> Trainings</th>
                                        <th width="20%">Target Planned</th>
                                        <th width="20%">Target Achieved</th>
                                        <th width="15%">Rating by Self</th>
                                        <th width="2%">Rating by Appraiser</th>
                                        <th width="2%">Rating by Reviewer</th>
                                        <th width="1%"></th>
                                    </tr>
                                </thead>

                                <tbody >
                                    <tr v-for="(input,k) in t" :key="k">
                                        <td><input type="text" class="form-control" v-model="input.title"></td>
                                        <td><input type="text" class="form-control" v-model="input.target_planned"></td>
                                        <td><input type="text" class="form-control" v-model="input.target_achieved"></td>
                                        <td>
                                            <select class="form-control" v-model="input.rating_by_self" required>
                                                <option value=""></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" readonly></td>
                                        <td><input type="text" class="form-control" readonly></td>
                                         <td>
                                            <span>
                                                <button class="btn btn-danger btn-sm" v-show="k || ( !k && t.length > 1)" @click="remove(k, 'tp')">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <button class="btn btn-success btn-sm" v-show="k == t.length-1" @click="add(k, 'tp')">
                                                <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                                <tfoot>
                        
                                   <!-- <tr>
                                        <td colspan='7'>
                                            <button class="btn btn-sm btn-danger" @click.prevent="add(k)" >
                                                <i class="fa fa-plus"></i>
                                                Add Set Objective
                                            </button>                        
                                        </td>
                                    
                                    </tr> -->
                                </tfoot>
                            </table>
                        </div>
                </div>
              </div>
            </div>
            <!-- training performance: ends -->
           
        </div>   
    </div>
    
    <div class="col-lg-8 col-md-12 mb-3">
        <div><small class="text-dark"> Upload justification, if any. (Maximum upload 2MB)</small></div>
        <input type="file" @change="listenToSelectedImage">
    </div>    

    <div class="col-lg-4 col-md-12">
        <!-- <input type="hidden" value="{{form_completion_status->staff_id}}" name="staff_id"/> -->
        <button type="submit" class="btn btn-danger" @click.prevent="verifyDetails">
            Submit to Appraiser
        </button>
    </div>
  </div>
 
   
   
</form>

</template>



<script>

import {RotateSquare5} from 'vue-loading-spinner'
import Swal from 'sweetalert2'

export default {
   
    data() {
        return {
            f: [{
                title: "",
                target_planned: "",
                target_achieved: "",
                rating_by_self: ""
            }],
            c: [{
                title: "",
                target_planned: "",
                target_achieved: "",
                rating_by_self: ""
            }],
            p: [{
                title: "",
                target_planned: "",
                target_achieved: "",
                rating_by_self: ""
            }],
            b: [{
                title: "",
                rating_by_self: ""
            }],
            t: [{
                title: "",
                target_planned: "",
                target_achieved: "",
                rating_by_self: ""
            }],
            valErrors: [],
            proof: null
            
        }
    },
    methods: {
        listenToSelectedImage(e){
            this.proof = e.target.files[0];
            console.log(this.proof);
        },
            
        add(index, context) {
            let arr = []
            if(context == 'cp'){ arr = this.c}
            if(context == 'fp'){ arr = this.f}
            if(context == 'pp'){ arr = this.p}
            if(context == 'bp'){ arr = this.b}
            if(context == 'tp'){ arr = this.t}

            if(context == 'bp'){
                arr.push(
                    {
                        title: "",
                        rating_by_self: ""
                    }
                );
            }else{
                arr.push(
                {
                    title: "",
                    target_planned: "",
                    target_achieved: "",
                    rating_by_self: ""
                }
            );
            }
            
           
            
        },
        remove(index, context) {
            let arr = []
            if(context == 'cp'){ arr = this.c}
            if(context == 'fp'){ arr = this.f}
            if(context == 'pp'){ arr = this.p}
            if(context == 'bp'){ arr = this.b}
            if(context == 'tp'){ arr = this.t}

            arr.splice(index, 1);
        },
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
            this.loadingAlert()

            let arr = [this.f, this.c, this.p, this.b, this.t]
            let arrTitle = ["Financial Performance", "Customer Performance", "Process/Operations", "Behavioural Attributes", "Training"]
            let arrItem = []
            this.valErrors = []

            for(var x=0; x < arr.length; x++){
                arrItem = []
                arrItem = arr[x]
                let isSame = this.arraysAreIdentical(arrItem, this.b)

                console.log( x.toString() + " " + isSame)

               if(arrItem === this.b){
                   let count = 1
                    arrItem.forEach((item) => {
                        if(item.title.trim().length === 0 ){this.valErrors.push(arrTitle[x] + ": 'Title' is required.Row "+ count)}                                                 
                        if(item.rating_by_self.trim().length === 0 ){this.valErrors.push(arrTitle[x] + ": 'Rating by self' is required.Row "+ count)}                       
                                                                           
                    })
                }
                else{
                    let count = 1
                    arrItem.forEach((item) => {
                          
                        if(item.title.trim().length === 0 ){this.valErrors.push(arrTitle[x] + ": 'Title' is required.Row "+ count)} 
                        if(item.target_planned.trim().length === 0 ){this.valErrors.push(arrTitle[x] + ": 'Target Planned' is required.Row "+ count)} 
                        if(item.target_achieved.trim().length === 0 ){this.valErrors.push(arrTitle[x] + ": 'Target Achieved' is required.Row "+ count)}                                               
                        if(item.rating_by_self.trim().length === 0 ){this.valErrors.push(arrTitle[x] + ": 'Rating by self' is required.Row "+ count)}
                        
                    })
                }
                
                
            }
            
            if(this.proof != null){
                this.uploadProof()
            }
            else{
                this.uploadDetails()
            }
            
        },
        uploadDetails(){
            let formData = {
                f: this.f,
                c: this.c,
                p: this.p,
                b: this.b,
                t: this.t,
                proof: this.proof
            }

            if(this.valErrors.length < 1){
                axios.post("testy", formData).then( resp => {
                  
                    this.successAlert("Appraisal report submitted successfully", "Thank you for your time!");
                 
                }).catch( error => {
                   
                    this.errorAlert('Something went wrong! We encountered an error connecting to the server');
                  
                })
            }
            else{
                this.valErrors.forEach( err => {
                    
                    this.errorAlert('It seems you didn\'t complete all the required fields!', 'See form for more details');
                    
                })
            }          
        },
        uploadProof(){
            let formData = new FormData();          
            formData.append('proof', this.proof);
                
            const config = {
                headers: {'content-type': 'multipart/form-data'}
            }

            axios.post("upload_proof", formData, config).then( response => {

                if(response.status == 200 || response.status == 201){                       

                    if(response.data.hasOwnProperty('errors')){

                        this.valErrors = response.data.errors;
                        this.errorAlert("We could not upload your file...", this.valErrors[0])
                       
                        
                    }else{    
                        this.uploadDetails();                      
                    }
                }
                else{                      
                    this.errorAlert("An error occured", " Please refresh or try again later")                     
                }               
                                                                     
            }).catch( error => {
                   
                this.errorAlert('Something went wrong! We encountered an error connecting to the server');
                  
            })
            
        },
        arraysAreIdentical(arr1, arr2){
            if (arr1.length !== arr2.length) return false;
            for (var i = 0, len = arr1.length; i < len; i++){
                if (arr1[i] !== arr2[i]){
                    return false;
                }
            }
            return true; 
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
                title: "Success",
                text: text,
                showConfirmButton: true,
                allowOutsideClick: false,
                footer: footer
            }).then((result) => {
                if (result.value) {
                    window.location.href = "self_appraisal"
                }
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
    
    },
   
}
</script>