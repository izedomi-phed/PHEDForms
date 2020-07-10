<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PHED FORMS') }}</title>


    <!-- Styles -->
    <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/thesaas.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">


    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">




    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light elevation-2">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <small>{{ Auth::user()->email }}</small>
        </a>
      </li>
       <li class="nav-item">

        <a class="text-dark nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            <strong>{{ __('Logout') }}</strong>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bg-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <img src="{{ asset('images/phed-logo.jpg') }}" alt="HCM APPRAISAL" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-bold">PHED STAFF</span>
      <!-- <span class="brand-text font-weight-bold">HCM APPRAISAL</span> -->
    </a>

      <hr>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
          <img src="https://d3ayyz93zozlya.cloudfront.net/global-images/global/user-placeholder-image-01.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
         <small>  <a href="#" class="d-block text-dark">{{ Auth::user()->name }}</a></small>
        </div>
      </div>
      <hr>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <h3 class="mb-3"><strong class="text-white pl-3"><a href="{{route('dashboard-index')}}">Dashboard</a></strong></h3>
          </li>


          @if($leave_request_count > 0)
            <li class="">
              <h6 class="mb-3"><strong class="pl-3">
                <a href="{{route('leave-request-approval-list')}}">Leave Request ({{$leave_request_count}})</</a>
                </strong>
             </h6>
            </li>
          @endif

          @if($accessLevel != "staff")
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link text-dark">
              <i class="nav-icon fa fa-book"></i>
              <p>
                 Roles
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="{{route('access-requests', ['request' => 'dl_enhance'])}}" class="nav-link text-dark @if(Route::current()->getName() == 'home'){{'bg-white'}}@endif">
                  <i class="fa fa-circle nav-icon"></i>
                  <p>STAFF</p>
                </a>
              </li>

              @if($accessLevel != "staff")
              <li class="nav-item">
                 <a href="{{route('change-role', ['new_role' => $accessLevel, 'access_level' => $accessLevel])}}" class="nav-link text-dark @if(Route::current()->getName() == 'change-role'){{'bg-white'}}@endif">
                    <i class="fa fa-circle nav-icon"></i>
                    <p>Admin-{{strtoupper($accessLevel)}}</p>
                  </a>
              </li>
              @endif
            </ul>
            </li>
            @endif


            <li class="nav-item has-treeview">
            <a href="#" class="nav-link text-dark">
              <i class="nav-icon fa fa-book"></i>
              <p>
                 Forms
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('access-requests', ['request' => 'dl_enhance'])}}" class="nav-link text-dark">
                  <i class="fa fa-circle nav-icon"></i>
                  <p>DLEnhance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('access-requests', ['request' => 'sage'])}}" class="nav-link text-dark">
                  <i class="fa fa-circle nav-icon"></i>
                  <p>Sage</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('access-requests', ['request' => 'leave'])}}" class="nav-link text-dark">
                  <i class="fa fa-circle nav-icon"></i>
                  <p>Leave</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link text-dark">
                  <i class="fa fa-circle nav-icon"></i>
                  <p>VPN (Non-Staff)</p>
                </a>
              </li>
            </ul>
            </li>

            @if(Auth::user()->status == "READY")
            <li class="nav-item">
              <a href="{{route('profile')}}" class="nav-link text-dark  @if(Route::current()->getName() == 'profile'){{'bg-white'}}@endif">
                <i class="fa fa-user-circle nav-icon"></i>
                <p>Profile</p>
              </a>
            </li>
            @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('msg')
    <!-- Main content -->
    <section class="contents" id="app">
      <div class="container-fluid" style="padding-top:20px">
             @yield('content')
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href=".">PHED APPRAISAL</a>.</strong>
    All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>


<!-- AdminLTE App -->


<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<script src="{{ asset('assets/js/core.min.js') }}"></script>
<script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('js/staff.js') }}"></script>


<script>
    $(document).ready(function(){
        // personal information form
        $('#submit-modal').click(function(){
           // $('#eModal').modal('hide');
            $('#submit').click();
        });

    });
</script>

  <script>
        $(document).ready(function(){

            var count = 0;
            var countf = 0;
            var countc = 0;
            var countp = 0;
            var countt = 0;
            var c;

            count++
            countf++
            countc++
            countp++
            countt++
            //dynamic_field(1, "all");
            financial(1);
            customer(1);
            process(1);
            training(1);
            behaviour(1);

            function financial(number){
                c = number

                var html = "<tr id='rem-fdt-"+c+"'>";
                html += "<td><input type='text' name='title_f[]' class='form-control' required/></td>";
                html += "<td><input type='text' name='target_planned_f[]' class='form-control' required /></td>";
                html += "<td><input type='text' name='target_achieved_f[]' class='form-control' required /></td>";
                html += "<td>";
                html += "<select name='rating_by_self_f[]' class='form-control' required>";
                html += "<option value=''></option>";
                html += "<option>1</option>";
                html += "<option>2</option>";
                html += "<option>3</option>";
                html += "<option>4</option>";
                html += "<option>5</option>";
                html += "</select></td>";
                html += "<td><input type='text' name='rating_by_appraisal_f[]' class='form-control' readonly /></td>";
                html += "<td><input type='text' name='rating_by_reviewer_f[]' class='form-control' readonly /></td>";


                if(c > 1){
                    html += "<td><button type='button' class='btn btn-danger fdt' id='fdt'><i class='fa fa-times'></i></button></td></tr>";
                }

                $('#body_fdt').append(html);

            }

            function customer(number){
                c = number

                var html = "<tr id='rem-cdt-"+c+"'>";
                html += "<td><input type='text' name='title_c[]' class='form-control' required/></td>";
                html += "<td><input type='text' name='target_planned_c[]' class='form-control' required /></td>";
                html += "<td><input type='text' name='target_achieved_c[]' class='form-control' required /></td>";
                html += "<td>";
                html += "<select name='rating_by_self_c[]' class='form-control' required>";
                html += "<option value=''></option>";
                html += "<option>1</option>";
                html += "<option>2</option>";
                html += "<option>3</option>";
                html += "<option>4</option>";
                html += "<option>5</option>";
                html += "</select></td>";
                html += "<td><input type='text' name='rating_by_appraisal_c[]' class='form-control' readonly /></td>";
                html += "<td><input type='text' name='rating_by_reviewer_c[]' class='form-control' readonly /></td>";


                if(c > 1){
                    html += "<td><button type='button' class='btn btn-outline-danger cdt' id='cdt'><i class='fa fa-times'></i></button></td></tr>";
                }

                $('#body_cdt').append(html);

            }

            function process(number){
                c = number

                var html = "<tr id='rem-pdt-"+c+"'>";
                html += "<td><input type='text' name='title_p[]' class='form-control' required/></td>";
                html += "<td><input type='text' name='target_planned_p[]' class='form-control' required /></td>";
                html += "<td><input type='text' name='target_achieved_p[]' class='form-control' required /></td>";
                html += "<td>";
                html += "<select name='rating_by_self_p[]' class='form-control' required>";
                html += "<option value=''></option>";
                html += "<option>1</option>";
                html += "<option>2</option>";
                html += "<option>3</option>";
                html += "<option>4</option>";
                html += "<option>5</option>";
                html += "</select></td>";
                html += "<td><input type='text' name='rating_by_appraisal_p[]' class='form-control' readonly /></td>";
                html += "<td><input type='text' name='rating_by_reviewer_p[]' class='form-control' readonly /></td>";


                if(c > 1){
                    html += "<td><button type='button' class='btn btn-sm btn-outline-danger pdt' id='pdt'><i class='fa fa-times'></i></button></td></tr>";
                }

                $('#body_pdt').append(html);

            }

            function training(number){
                c = number

                var html = "<tr id='rem-tdt-"+c+"'>";
                html += "<td><input type='text' name='title_t[]' class='form-control' required/></td>";
                html += "<td><input type='text' name='target_planned_t[]' class='form-control' required /></td>";
                html += "<td><input type='text' name='target_achieved_t[]' class='form-control' required /></td>";
                html += "<td>";
                html += "<select name='rating_by_self_t[]' class='form-control' required>";
                html += "<option value=''></option>";
                html += "<option>1</option>";
                html += "<option>2</option>";
                html += "<option>3</option>";
                html += "<option>4</option>";
                html += "<option>5</option>";
                html += "</select></td>";
                html += "<td><input type='text' name='rating_by_appraisal_t[]' class='form-control' readonly /></td>";
                html += "<td><input type='text' name='rating_by_reviewer_t[]' class='form-control' readonly /></td>";


                if(c > 1){
                    html += "<td><button type='button' class='btn btn-sm btn-outline-danger tdt' id='tdt'><i class='fa fa-times'></i></button></td></tr>";
                }

                $('#body_tdt').append(html);

            }

            function behaviour(number){
                c = number

                var html = "<tr id='rem-bdt-"+c+"'>";
                html += "<td>";
                html += "<select name='title_b[]' class='form-control' required>";
                html += "<option value=''></option>";
                html += "<option>Interpersonal skill: Willingness to help others, Relation with peers</option>";
                html += "<option>Communication skill: Thought clarity, Uses data, Ability to influence</option>";
                html += "<option>Team Spirit: Cooperate with others, Provide guidance and direction to others, Take responsibility and ownership</option>";
                html += "</select></td>";
                html += "<td>";
                html += "<select name='rating_by_self_b[]' class='form-control' required>";
                html += "<option value=''></option>";
                html += "<option>1</option>";
                html += "<option>2</option>";
                html += "<option>3</option>";
                html += "<option>4</option>";
                html += "<option>5</option>";
                html += "</select></td>";
                html += "<td><input type='text' name='rating_by_appraisal_b[]' class='form-control' readonly /></td>";
                html += "<td><input type='text' name='rating_by_reviewer_b[]' class='form-control' readonly /></td>";


                if(c > 1){
                    html += "<td><button type='button' class='btn btn-sm btn-outline-danger bdt' id='bdt'><i class='fa fa-times'></i></button></td></tr>";
                }

                $('#body_bdt').append(html);

            }


            //add element

            $('#add_fdt').click(function(event){
                event.preventDefault();
                countf++;
                financial(countf);
            });

            $('#add_cdt').click(function(event){
                event.preventDefault();
                countc++;
                customer(countc);
            });
            $('#add_pdt').click(function(event){
                event.preventDefault();
                countp++;
                process(countp);
            });
            $('#add_tdt').click(function(event){
                event.preventDefault();
                countt++;
                training(countt);
            });
            $('#add_bdt').click(function(event){
                event.preventDefault();
                count++;
                behaviour(count);
            });



            //delete element
            $(document).on('click', '#fdt', function(){
                $('#rem-fdt-'+countf).remove();
                c--
                countf--
            });
            $(document).on('click', '#cdt', function(){
                $('#rem-cdt-'+countc).remove();
                c--
                countc--
            });
            $(document).on('click', '#pdt', function(){
                $('#rem-pdt-'+countp).remove();
                c--
                countp--
            });
            $(document).on('click', '#tdt', function(){
                $('#rem-tdt-'+countt).remove();
                c--
                countt--
            });
            $(document).on('click', '#bdt', function(){
                $('#rem-bdt-'+count).remove();
                c--
                count--
            });

        });
    </script>



</body>
</html>
