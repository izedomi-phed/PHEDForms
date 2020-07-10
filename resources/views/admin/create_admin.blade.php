



@extends('layouts.auth')

@section('content')

<section class="mh-fullscreen bg-img center-vh p-20 bg-primary">
 <canvas class="constellation"></canvas>
    <div class="card card-shadowed p-20 w-400 mb-0 elevation-4" style="max-width: 100%">

      <div class="text-center">
        <a href='.'><img src="{{asset('images/PHEDLogo.jpg')}}" alt="phed logo"  style="width:100px;height:100px"/></a>
      <div>

      <h5 class="text-uppercase text-center">{{ __('Create New Admin') }}</h5>
      
       <form method="POST" action="{{ route('new_admin') }}">
             @csrf

            <div class="row">
                <div class="col-md-12">
                    @include('msg')
                </div>
            </div>

        <div class="form-group">
                     
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Full Name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
           
        </div>

        <div class="form-group">
           
            <input id="name" type="text" class="form-control @error('staff_id') is-invalid @enderror" name="staff_id" required autocomplete="name" autofocus placeholder="Staff Id">

            @error('staff_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
           
        </div>

         <div class="form-group">
                      
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          
        </div>

        <div class="form-group">
                   
                <select name="access" class="form-control" required="true">
                    <option value="">Select Role</option>
                    <option>IT</option>
                </select>

                @error('access')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            
        </div>

         <div class="form-group">
          
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
           
        </div>

        <div class="form-group">          

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
           
        </div>

        <div class="form-group">
          <button class="btn btn-bold btn-block btn-primary" type="submit">Create</button>
        </div>

      </form>

    </div>

</section>


@endsection
