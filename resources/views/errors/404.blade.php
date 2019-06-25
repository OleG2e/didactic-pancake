@extends('layouts.app')
@section('title', __('Not Found'))
@section('content')
    <div class="container">
        <div class="notification">
            <h1 class="title has-text-centered">{{__('Not Found')}}:404</h1>
        </div>
    </div>
@endsection