@extends('layouts.app')

@section('content')

   <section>
        <div class="container">
                        
            <h2 class="text-center">Welcome {{$admin_name}}</h2>
            
            <div class="row my-20">
                    
                <div class="col-12 col-md-12 mt-25">
                    <ul class="nav nav-vertical">
                        <li class="nav-item text-center">
                        <a class="nav-link active" data-toggle="tab" href="#new">
                            <h6>2019 Performance Appraisal Report : - 2nd Half Year Performance Appraisal</h6>
                        </a>
                        </li>           
                    </ul>
                </div>
            </div>

            <div class="row mb-10">
                <div class="col-md-12 text-center">  @if($query != null)<span>Show Result for <strong>"{{$query ?? ''}}"</strong></span>@endif </div>
            </div>
           
            <div class="row mb-10">
                
                <div class="col-md-8">
                    <form method="post" action="{{route('download-report')}}"> 
                        @csrf
                        <select name="ibc">
                            <option value="All">All IBCs</option>
                            @foreach($ibcs as $ibc)
                            <option>{{$ibc->title}}</option>
                            @endforeach
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
                    <form method="post" action="{{route('sort')}}"> 
                        @csrf
                        <select name="ibc">
                            <option value="All">All IBCs</option>
                            @foreach($ibcs as $ibc)
                            <option>{{$ibc->title}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-round btn-primary">sort</button>
                    </form>
                </div>
                    
            </div>
            <div class="row">
                <div class="col-md-12">
                 @include('msg')
                        <div class="table-responsive"> 

                            <table class="table table-bordered" id="user_table" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th><strong>EMPLOYEE</strong> </th>
                                        <th><strong>STAFF ID</strong></th>
                                        <th><strong>STATUS</strong></th>
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
                                              
                                             </td>
                                            <td> {{$employee->staff_id}}</td>
                                            <td>
                                                @if(($employee->status == "START_APPRAISAL") || ($employee->status == "TO_COMPLETE_FORM"))
                                                        Not Started
                                                       
                                                @endif
                                                @if($employee->status == "WAIT_APPRAISER") 
                                                        Sent to Appraiser
                                                        <br/>
                                                @endif
                                                
                                                @if($employee->status == "WAIT_REVIEWER") 
                                                        Sent to Reviewer
                                                        <br/>
                                                       
                                                @endif
                                                @if($employee->status == "TO_HR") 
                                                        Awaiting submission to HR
                                                       
                                                @endif
                                                @if($employee->status == "TO_REVIEWER") 
                                                        Awaiting submission to Reviewer
                                                @endif
                                                @if($employee->status == "COMPLETED")
                                                        Submitted
                                                @endif
                                            </td>
                                            <td>{{$employee->appraiser_rating}}</td>
                                            <td>{{$employee->reviewer_rating}}</td>
                                            <td>{{$employee->hhcm_rating}}</td>
                                            <td>{{$employee->cpo_rating}}</td>
                                            <td>
                                                 @if($admin_access == "performance")
                                                    <a class="btn btn-primary" href="{{route('reminder', ['id' => $employee->account_id])}}" title="send reminder">
                                                        <i class="fa fa-bell-o"></i>
                                                    </a>
                                                @endif 
                                                @if(($employee->status != "START_APPRAISAL") && ($employee->status != "TO_COMPLETE_FORM"))
                                        
                                                    <a class="btn btn-danger" href="download/{{$employee->staff_id}}" title="download report">
                                                     <i class="fa fa-download"></i>
                                                    </a>
                                                
                                                @endif
                                                @if($employee->proof != null)
                                                    <a class="btn btn-success" href="proof/{{$employee->proof}}" title="download proof"><i class='fa fa-file-text-o'></i> </a>
                                                @endif
                                               
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
@endsection
