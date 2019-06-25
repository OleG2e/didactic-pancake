@extends('layouts.app')
@section('title', __('Server Error'))
@section('content')
    <div class="container">
        <div class="notification">
            <h1 class="title has-text-centered">{{__('Server Error')}}:500</h1>
        </div>
    </div>
@endsection