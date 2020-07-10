@extends('layouts.auth')

@section('content')

<section class="mh-fullscreen bg-img center-vh p-20 bg-primary">
 <canvas class="constellation"></canvas>
    <div class="card card-shadowed p-20 w-700 mb-0 elevation-4" style="max-width: 100%">
      
      <div class="text-center">
         <a href='.'><img src="{{asset('images/PHEDLogo.jpg')}}" alt="phed logo"  style="width:100px;height:100px"/></a>
      <div>

      <h5 class="text-uppercase text-center">VERIFY YOUR EMAIL ADDRESS</h5>

      
      
       <div class="card-body text-dark">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-info p-2 m-1 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
        </div>

    </div>

</section>





@endsection
