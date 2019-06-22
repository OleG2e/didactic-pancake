@extends('layouts.app')
@section('title', 'Актуальные поездки')
@section('og:title', 'Актуальные поездки')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('trip.all') }}
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        <h4 class="title is-size-4">Актуальные поездки:</h4>
        <div class="content">
            <div class="dropdown is-hoverable">
                <div class="dropdown-trigger">
                    <button class="button is-rounded is-primary" aria-haspopup="true" aria-controls="dropdown-menu">
                        <span>Новая поездка</span>
                        <span class="icon is-small">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                    </button>
                </div>
                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                    <div class="dropdown-content">
                        <div class="dropdown-item">
                            <a class="button is-primary is-rounded" href="{{route('trip.create')}}">Создать поездку</a>
                        </div>
                        <div class="dropdown-item">
                            <a class="button is-info is-rounded"
                               href="https://pass.rzd.ru/tickets/public/ru?layer_name=e3-route&st0=Микунь&code0=2010210&st1=Сыктывкар&code1=2010280&dt0={{date('d.m.Y',time() + 86400)}}&tfl=3&md=0&checkSeats=0"
                               target="_blank">Купить ж/д билет
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a class="button is-info is-rounded" href="http://komiavtotrans.ru/" target="_blank">Купить
                                билет на автобус</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns is-multiline">
            @if (count($trips))
                @foreach($trips as $trip)
                    <div class="column is-narrow">
                        <div class="box">
                            <h4 class="title is-size-4">{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</h4>
                            <h5 class="subtitle"><strong>{{$trip->owner->name}}</strong>
                                <small> {{$trip->updated_at->diffForHumans()}}</small>
                            </h5>
                            <div class="content">
                                @php
                                    $dateTime = new DateTime($trip->date_time);
                                @endphp
                                Дата поездки: {{$dateTime->format('d.m.Y H:i')}}
                                <br>Осталось мест:<strong> {{$trip->passengers_count}}</strong>
                                <br><a href="{{route('trip.show', $trip)}}">Обсудить</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="container">
                    <div class="notification has-text-centered">
                        <span class="is-center">Объявлений пока что нет...</span>
                    </div>
                </div>
            @endif
        </div>
    @endcomponent
@endsection