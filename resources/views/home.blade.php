@extends('layouts.staff')

@section('content')


    <appraisee-details-component 
    :ibcs="{{$ibcs}}" 
    :email="'{{$email}}'" 
    :staff_id="'{{$staffId}}'"
    :first_name="'{{$firstname}}'"
    :last_name="'{{$lastname}}'">
    </appraisee-details-component>


@endsection
