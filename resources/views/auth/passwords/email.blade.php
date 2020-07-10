@extends('layouts.auth')

@section('content')

<section class="mh-fullscreen bg-img center-vh p-20 bg-primary">
 <canvas class="constellation"></canvas>
    <div class="card card-shadowed p-35 w-400 mb-0 elevation-4" style="max-width: 100%">

      <div class="text-center">
         <a href='.'><img src="{{asset('images/PHEDLogo.jpg')}}" alt="phed logo"  style="width:100px;height:100px"/></a>
      <div>

      <h5 class="text-uppercase text-center">Reset Password</h5>

         @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
      
       <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    @include('msg')
                </div>
            </div>

        <div class="form-group">
          <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
          <button class="btn btn-bold btn-block btn-primary" type="submit"> {{ __('Send Password Reset Link') }}</button>
        </div>
      </form>

    </div>

</section>
@endsection
