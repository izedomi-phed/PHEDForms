<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PHED FORMS') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script src="{{ asset('assets/js/core.min.js') }}"></script>
    <script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>


    <!-- Styles -->
    
    <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/thesaas.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">

      <nav class="topbar topbar-expand-md topbar-nav-centered">
        <div class="container">
          
          <div class="topbar-left">
            <button class="topbar-toggler">&#9776;</button>
            <a class="topbar-brand" href="{{ url('/') }}">
              <img class="logo-default" src="{{asset('images/PHEDLogo.jpg')}}" alt="logo">
              <img class="logo-inverse" src="{{asset('images/PHEDLogo.jpg')}}" alt="logo">
            </a>
          </div>

          <div class="topbar-right">
            <button class="drawer-toggler ml-12">&#9776;</button>
          </div>

        </div>
      </nav>

        <main class="py-4" style="margin-top: 50px">
            @yield('content')
        </main>
    </div>

     <!-- Drawer -->
     <div class="drawer">
      <div class="drawer-content">      
        <p class="text-primary"><strong>{{$admin_name}}</strong></p>
        <p>ACCESS - {{strtoupper($accessLevel)}}</p>        
        <hr>
        <br>
        <div class="row justify-content-center">
            <div class="col-6">
                @if (Route::has('login'))
                       
                    @auth
                        <a class="btn btn-sm btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                   
               @endif
               
            </div>
            <div class="col-6">
            
                <a href="{{route('change-role', ['new_role' => 'staff', 'access_level' => $accessLevel])}}" class="btn btn-sm btn-primary">
                    STAFF ROLE
                </a>
            </div>
        </div>
       

      </div>

      <button class="drawer-close"></button>
      <div class="drawer-backdrop"></div>
    </div>
    <!-- END Drawer -->


</body>
</html>
