@extends('layouts.staff')

@section('content')

    <profile-component :staff_id="'{{$staffId}}'"></profile-component>
@endsection