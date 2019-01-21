@extends('layouts.app')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
    @endif
    {{ Breadcrumbs::render('trip_all') }}
    <h1 class="title">Объявления:</h1>
    @foreach($trip as $item)
        <li>
            <a href="trip/{{$item->id}}">{{$item->description}}</a>
        </li>
    @endforeach
    <div class="control">
        <a class="button is-primary" href="trip/create">Создать</a>
    </div>
    {{--<vuejs-datepicker :language="ru"></vuejs-datepicker>--}}
@endsection

