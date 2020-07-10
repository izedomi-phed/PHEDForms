@extends('layouts.app')

@section('content')

   <section>
        <div class="container">
                        
          
            <div class="row my-20">                   
                <div class="col-12 col-md-12 mt-25">
                    <ul class="nav nav-vertical">
                        <li class="nav-item text-center">
                        <a class="nav-link active" data-toggle="tab" href="#new">
                            <h6 class="text-dark">2019 Performance Appraisal Report : - 2nd Half Year Performance Appraisal</h6>
                            <!-- <p class="text-center text-white">PHED EMPLOYEES APPRAISALS</p> -->
                        </a>
                        </li>           
                    </ul>
                </div>
            </div>
            <div class="row justify-content-center my-10">                           
                <div class="col-md-8 text-center">
                    @if($query != null)<span>Show Result for <strong>"{{$query ?? ''}}"</strong></span>@endif
                </div>                
            </div>
            <div class="row">               
                <div class="col-md-8">

                    <form method="post" action="{{route('sort')}}"> 
                        @csrf
                        <select name="ibc">
                            <option>All</option>
                            @foreach($ibcs as $ibc)
                            <option>{{$ibc->title}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-round btn-primary">sort</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <p class="text-right">
                        <button type="button" class="btn btn-sm btn-round btn-primary" data-toggle="modal" data-target="#batchNormalize">Batch Normalize</button>
                    </p>
                </div>
            </div>
            <div class="row">
                    <div class="col-12 col-md-12">
                         @include('msg')
                        <div class="table-responsive">
                             
                            <table class="table table-bordered" id="user_table" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th><strong>EMPLOYEE</strong> </th>
                                        <th><strong>STAFF ID</strong></th>
                                        <th><strong>APPRAISAL<br/> RATING</strong></th>
                                        <th><strong>REVIEWER<br/> RATING</strong></th>
                                        <th><strong>HHCM</strong></th>
                                        <th><strong>CPO</strong></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                        <tr class="text-center">
                                            <td> 
                                                <a href="employee/{{$employee->account_id}}/{{$employee->staff_id}}">
                                                     {{$employee->name}}
                                                </a>
                                                @if($employee->proof != null)
                                                    <a class="btn btn-success btn-sm btn-round" href="proof/{{$employee->proof}}"> proof </a>
                                                @endif
                                             </td>
                                            <td> {{$employee->staff_id}}</td>
                                            <td>{{$employee->appraiser_rating}}</td>
                                            <td>{{$employee->reviewer_rating}}</td>
                                            <td>{{$employee->hhcm_rating}}</td>
                                            <td>{{$employee->cpo_rating}}</td>
                                            <td> 
                                                 @if($employee->reviewer_rating != null || $employee->hhcm_rating != null)
                                                    <button type="button" class="btn btn-sm btn-round btn-secondary" data-toggle="modal" data-id="{{$employee->staff_id}}" data-target="#exampleModal">Normalize</button>
                                                  @endif                                                                           
                                                <a class="btn btn-danger btn-sm btn-round" href="employee/{{$employee->account_id}}/{{$employee->staff_id}}">
                                                details
                                                </a>                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="text-center">
                                        <td colspan='8<br/>'>
                                           phed appraisal : 2019                             
                                        </td>
                                    
                                    </tr>
                                </tfoot>
                                
                            </table>
                            {{ $employees->links() }}
                        </div>
                    </div>
                    
            </div>

        </div>
    </section>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="exampleModalLabel">Normalize</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="normalize">
                    @csrf

                    <div class="modal-body">
                        <select name="normalize_criteria" class="form-control mb-10" required>
                            <option value="">Select basis for normalization</option>
                            <option value="reviewer">Reviewer Rating</option>
                            <option value="hhcm">Head Of HCM Rating</option>
                        </select>
                         <input type="number" name="rating" max="100" class="form-control" placeholder="enter normalization value" required/>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="staff_id" id="n_staff_id"/>
                        <input type="hidden" name="admin_access" value="cpo"/>
                        <button type="submit" class="btn btn-primary" id="b-submit-modal">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <div class="modal fade" id="batchNormalize" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="exampleModalLabel">Batch Normalize</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="batch_normalize">
                    @csrf
                    <div class="modal-body">

                          <select class="form-control form-control-sm mb-3" name="ibc" required>
                            <option value="">Select IBC </option>
                            @foreach($ibcs as $ibc)
                                <option>{{$ibc->title}}</option>
                            @endforeach
                        </select>
                        <select name="normalize_criteria" class="form-control mb-3" required>
                            <option value="">Select basis for normalization</option>
                            <option value="reviewer">Reviewer Rating</option>
                            <option value="hhcm">Head Of HCM Rating</option>
                        </select>

                         <input type="number" name="rating" max="100" class="form-control" placeholder="enter normalization value" required/>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="admin_access" value="cpo"/>
                        <button type="submit" class="btn btn-primary" id="submit-modal">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <script>
       
       
        $(document).ready(function(){

            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var staff_id = button.data('id') // Extract info from data-* attributes
                var modal = $(this)
                modal.find('.modal-title').text('STAFF ID: ' + staff_id)
                $('#n_staff_id').val(staff_id)
            });

            $('#submit-modal').click(function(){
                var str = $('#rating').val()
               if(str.length != 0){
                    $('#exampleModal').modal('hide')
               }
                
            });
        });

    </script>
    
    
    

@endsection
