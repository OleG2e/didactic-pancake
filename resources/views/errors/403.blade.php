@extends('layouts.app')
@section('title', __('Forbidden'))
@section('content')
    <div class="container">
        <div class="notification">
            <h1 class="title has-text-centered">{{__('Forbidden')}}:403</h1>
        </div>
    </div>
@endsection
