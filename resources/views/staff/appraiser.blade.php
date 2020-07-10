@extends('layouts.staff')

@section('content')

       <!-- Small boxes (Stat box) -->
        <div class="row justify-content-center mt-10">
          <div class="col-md-10">
          <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-white elevation-3 text-white">
              <div class="inner">
                <h3>{{$total}}</h3>

                <p>Total Appraisees</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag text-primary"></i>
              </div>
              <a href="{{$role}}/?q=total" class="small-box-footer text-light">More info <i class="fa fa-arrow-circle-right tex-white"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-white elevation-3 text-white">
              <div class="inner">
                <h3>{{$completed}}</h3>
                <p>Completed</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars text-primary"></i>
              </div>
              <a href="{{$role}}/?q=completed" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-white elevation-3 text-white">
              <div class="inner">
                <h3>{{$uncompleted}}</h3>

                <p>Uncompleted</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add text-primary"></i>
              </div>
              <a href="{{$role}}/?q=uncompleted" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-white elevation-3 text-white">
              <div class="inner">
               
                <h3>{{$success}}<sup style="font-size: 20px">%</sup></h3>

                <p>Success Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph text-primary"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> 
            </div>
          </div>
          <!-- ./col -->
          </div>
          </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">

                    <div class="col-md-4">
                      @if($query != "")
                        <p> Search result for {{$query}}</p>
                      @endif
                    </div>

                    <div class="col-md-12 mb-3 float-right">
                        <form method="get" action="{{$role}}" class="form-inline">
                            @csrf
                           
                              <select name="ibc" class="form-control form-control-sm required mr-2">
                                  <option value=""></option>
                                  @foreach($ibcs as $ib)
                                  <option>{{$ib->title}}</option>
                                  @endforeach
                              </select>
                              <input type="hidden" name="role" value="{{$role}}" />
                              <button type="submit" name="sort" class="btn btn-sm btn-round btn-outline-info"> Sort </button>
                        </form>  

                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="table table-striped table-hover">
                    <table width="100%">                      
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>STAFF ID</th>
                                <th>NAME</th>
                                <th>DESIGNATION</th>
                                <th>ACTION</th>
                            </tr>

                        </thead>

                        <tbody>
                          @if(count($appraisees) > 0)
                              <?php $x = 1; ?>
                              @foreach($appraisees as $appraisee)
                              <tr>
                                  <td><?php echo $x++; ?></td>
                                  <td>{{$appraisee->staff_id}}</td>
                                  <td>{{$appraisee->name}}</td>
                                  <td>{{$appraisee->designation}}</td>
                                  <td>
                                                                                                      
                                      @if($appraisee->status == "UNCOMPLETED")
                                          <a class="btn btn-sm btn-outline-danger" href="../.../../{{$role}}/employee/{{$appraisee->id}}/{{$appraisee->staff_id}}">
                                            Rate Staff  
                                          </a>                                                                           
                                      @else
                                          <p> Completed </p>
                                      @endif
                                                                                                  
                                  </td>
                              </tr>                          
                              @endforeach
                            @else
                              <tr>
                                  <td colspan="5" class="text-center"><p> No Appraisee found</p></td>
                              </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


@endsection
