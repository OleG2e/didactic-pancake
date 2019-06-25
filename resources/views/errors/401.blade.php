@extends('layouts.app')
@section('title', __('Unauthorized'))
@section('content')
    <div class="container">
        <div class="notification">
            <h1 class="title has-text-centered">{{__('Unauthorized')}}:401</h1>
        </div>
    </div>
@endsection
