@extends('layouts.staff')

@section('content')

<leave-form-request
:email="'{{$email}}'" 
:staff_id="'{{$staffId}}'"
:last_name="'{{$lastname}}'"
:first_name="'{{$firstname}}'"
:request_type="'{{$requestType}}'"
:other_name="'{{$otherName}}'">
</leave-form-request>
    
@endsection
