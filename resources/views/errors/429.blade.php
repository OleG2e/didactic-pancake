@extends('layouts.app')
@section('title', __('Too Many Requests'))
@section('content')
    <div class="container">
        <div class="notification">
            <h1 class="title has-text-centered">{{__('Too Many Requests')}}:429</h1>
        </div>
    </div>
@endsection