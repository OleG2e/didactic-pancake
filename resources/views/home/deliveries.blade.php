@extends('layouts.app')
@section('title', 'Мои передачки')
@section('og:title', 'Мои передачки')
@section('content')
    @component('components.hero')
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        @include('components.home-nav')
        <nav class="level is-mobile">
            <div class="level-item level-left">
                <div class="control">
                    <p class="title is-size-4">Мои передачки:</p>
                </div>
            </div>
            <div class="level-item level-right">
                <a class="button is-primary is-rounded" href="{{route('delivery.create')}}">Создать передачку</a>
            </div>
        </nav>
        <div class="columns is-multiline">
            @if(count($myDeliveries))
                @foreach($myDeliveries as $trip)
                    <div class="column is-narrow is-one-quarter">
                        <div class="box">
                            <div class="level is-mobile">
                                <div class="level-left">
                                    <div class="level-item">
                                        <p class="title is-size-5">{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</p>
                                    </div>
                                </div>
                                @can('delete', $trip)
                                    <div class="level-right">
                                        <div class="level-item">
                                            <a class="delete modal-button" data-target="modal-bis-{{$trip->id}}"></a>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                            <div class="modal" id="modal-bis-{{$trip->id}}">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                        <p class="modal-card-title">Подтвердите удаление</p>
                                        <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Удалить передачку от {{$trip->created_at}}?
                                    </section>
                                    <footer class="modal-card-foot">
                                        <form method="post" action="{{route('delivery.destroy', $trip)}}">
                                            @method('delete')
                                            @csrf
                                            <button class="button is-danger" type="submit">
                                                    <span class="icon is-small">
                                                        <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                    </span>
                                                <span>Удалить!</span>
                                            </button>
                                            <a class="button is-info">Отмена</a>
                                        </form>
                                    </footer>
                                </div>
                            </div>
                            <p class="subtitle"><small>{{\App\Helpers::dateFormat($trip->created_at, 'd.m.Y')}}</small></p>
                            <div class="content">
                                {{\Illuminate\Support\Str::words($trip->description, 20)}}
                                <br>
                                <a href="{{route('delivery.show', $trip)}}">
                                    Обсудить
                                </a>
                                <form method="post" action="{{route('update.relevance.delivery', $trip)}}">
                                    @method('patch')
                                    @csrf
                                    <div class="field">
                                        <input id="switch-{{$trip->id}}" type="checkbox" name="relevance" class="switch"
                                               onchange="this.form.submit()" {{$trip->relevance ? 'checked' : ''}}>
                                        <label for="switch-{{$trip->id}}">Показ</label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @component('components.empty-records')
                    Передачек, размещённых вами, нет
                @endcomponent
            @endif
        </div>
    @endcomponent
@endsection