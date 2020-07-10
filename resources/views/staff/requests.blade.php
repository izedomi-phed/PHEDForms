@extends('layouts.staff')

@section('content')

<generic-request-component 
:email="'{{$email}}'" 
:staff_id="'{{$staffId}}'"
:last_name="'{{$lastname}}'"
:first_name="'{{$firstname}}'"
:request_type="'{{$requestType}}'"
:other_name="'{{$otherName}}'">
</generic-request-component>
    
@endsection
