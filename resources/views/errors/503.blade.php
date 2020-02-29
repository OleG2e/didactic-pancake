@extends('layouts.app')
@section('title', __('Service Unavailable'))
@section('content')
    <div class="container">
        <div class="notification">
            <h1 class="title has-text-centered">Сайт в разработке</h1>
            <!--<h1 class="title has-text-centered">{{__('Service Unavailable')}}:503</h1>-->
        </div>
    </div>
@endsection