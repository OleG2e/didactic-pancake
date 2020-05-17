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
        <nav class="level">
            <div class="content level-item level-left">
                <div class="dropdown is-hoverable">
                    <div class="dropdown-trigger">
                        <button class="button is-rounded @auth is-primary @else is-info @endauth" aria-haspopup="true"
                                aria-controls="dropdown-menu">
                            <span>Новая поездка</span>
                            <span class="icon is-small">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                        <div class="dropdown-content">
                            @auth
                                <div class="dropdown-item">
                                    <a class="button is-primary is-rounded" href="{{route('trip.create')}}">Создать
                                        поездку</a>
                                </div>
                            @endauth
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
        </nav>
        <p class="title is-size-4">Актуальные поездки:</p>
        @if (count($trips))
            <div class="columns is-multiline">
                @foreach($trips as $trip)
                    <div class="column is-narrow is-one-quarter">
                        <div class="box">
                            <p class="title is-size-5">{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</p>
                            <p class="subtitle is-size-5"><strong>{{$trip->owner->username}}</strong>
                                <small class="is-size-6"> {{$trip->updated_at->diffForHumans()}}</small>
                            </p>
                            <div class="content">
                                Дата поездки: {{\App\Helpers::dateFormat($trip->date_time)}}
                                <br>Осталось мест:<strong> {{$trip->passengers_count}}</strong>
                                <br><a href="{{route('trip.show', $trip)}}">Обсудить</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @include('components.links', ['model' => $trips])
        @else
            @component('components.empty-records')
                Поездок нет...
            @endcomponent
        @endif
    @endcomponent
@endsection