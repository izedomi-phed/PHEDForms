@if(count($errors))
    @foreach($errors->all() as $error)
        <div class="alert alert-danger  mt-3 text-center">
            <small>{{$error}}</small>
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

         @if(session('success') == "Payment Completed")
            <p class="text-center text-danger lead"> {{session('success')}} !</p>
            <small class="text-center"> make another payment </small>
         @else
          
            <?php $a = session('success'); ?>
           {!! nl2br($a) !!}

         @endif
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show text-center">
        <button type="button" class="close btn-sm" data-dismiss="alert" aria-label="Close">
            <small aria-hidden="true">&times;</small>
        </button>
        <small>  <?php $a = session('error'); ?>
           {!! nl2br($a) !!}
        </small>
    </div>
@endif
