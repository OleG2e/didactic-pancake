@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('trip_all') }}
        <nav class="level">
            <div class="level-item level-left field is-grouped">
                <div class="control">
                    <a class="button is-primary is-rounded" href="/trips/create">Создать поездку</a></div>
                <div class="control">
                    <a class="button is-info is-rounded" href="http://komiavtotrans.ru/" target="_blank">Купить билет на
                        автобус</a>
                </div>
            </div>
        </nav>
        @if (session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif
        <div class="title">Актуальные поездки:</div>
        <div class="columns is-multiline">
            @foreach($trips as $trip)
                <div class="column is-narrow">
                    <div class="box" style="width: 250px">
                        <p class="title">{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</p>
                        <p class="subtitle"><strong>{{$trip->owner->name}}</strong>
                            <small> {{$trip->updated_at->diffForHumans()}}</small>
                        </p>
                        <div class="content">
                            @php
                                $dateTime = new DateTime($trip->date_time);
                            @endphp
                            <p> Дата поездки: {{$dateTime->format('d.m.Y H:i')}}
                                @if($trip->passengers_count)<br>Осталось мест:
                                <strong>{{$trip->passengers_count}}</strong>@endif
                                @if($trip->load)<br>Есть место для груза@endif</p>
                            <a href="/trips/{{$trip->id}}">
                                Обсудить
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endcomponent
@endsection