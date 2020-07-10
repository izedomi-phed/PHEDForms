@extends('layouts.auth')

@section('content')

   <div class="mh-fullscreen bg-img center-vh p-20 bg-primary">
         <canvas class="constellation"></canvas>

    <div class="card card-shadowed p-20 w-400 mb-0" style="max-width: 100%">

      <div class="text-center">
            <a href='.'><img src="{{asset('images/PHEDLogo.jpg')}}" alt="phed logo"  style="width:100px;height:100px"/></a>
      </div>
      <h5 class="text-uppercase text-center">Reset Password</h5>
      <br><br>

       <form method="POST" action="{{ route('password.update') }}">
            @csrf
           <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">

             <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
       </div>

        <div class="form-group">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
        </div>
        <br>

        <div class="form-group text-center justify-content-center">
            <button type="submit" class="btn btn-primary">
                <span>Reset Password</span>
            </button>
        </div>



      </form>

    </div>
</div>
@endsection
