@extends('layouts.app')
@section('title', 'Мои поездки')
@section('og:title', 'Мои поездки')
@section('content')
    @component('components.hero')
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        @include('components.home-nav')
        <nav class="level">
            <div class="level-item level-left">
                <div class="control">
                    <h4 class="title is-size-4">Мои поездки:</h4>
                </div>
            </div>
            <div class="level-item" style="padding-bottom: 10px">
                <a class="button is-primary is-rounded" href="{{route('trip.create')}}">Создать поездку</a>
            </div>
        </nav>
        <div class="columns is-multiline">
            @if(count($myTrips))
                @foreach($myTrips as $trip)
                    <div class="column is-narrow">
                        <div class="box">
                            <div class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        <h4 class="title is-size-4">{{$trip->category->title}}</h4>
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
                            @can('delete', $trip)
                                <div class="modal" id="modal-bis-{{$trip->id}}">
                                    <div class="modal-background"></div>
                                    <div class="modal-card">
                                        <header class="modal-card-head">
                                            <p class="modal-card-title">Подтверди удаление</p>
                                            <button class="delete" aria-label="close"></button>
                                        </header>
                                        <section class="modal-card-body">
                                            Удалить пост от {{$trip->created_at}}?
                                        </section>
                                        <footer class="modal-card-foot">
                                            <form method="post" action="{{route('trip.destroy', $trip)}}">
                                                @method('delete')
                                                @csrf
                                                <button class="button is-danger" type="submit">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                                    </span>
                                                    <span>Удалить!</span>
                                                </button>
                                                <a class="button is-info">Отмена</a>
                                            </form>
                                        </footer>
                                    </div>
                                </div>
                            @endcan
                            <h4 class="title is-size-4">{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</h4>
                            <h6 class="subtitle is-size-6">Дата:
                                <br>{{$trip->created_at}}</h6>
                            <div class="content">
                                <div class="more">{{$trip->description}}</div>
                                <a href="{{route('trip.show', $trip)}}">
                                    Обсудить
                                </a>
                                @can('update', $trip)
                                    <form method="post" action="{{route('update.relevance.trip', $trip)}}">
                                        @method('patch')
                                        @csrf
                                        <div class="field">
                                            <input id="switch-{{$trip->id}}" type="checkbox" name="relevance"
                                                   class="switch"
                                                   onchange="this.form.submit()" {{$trip->relevance ? 'checked' : ''}}>
                                            <label for="switch-{{$trip->id}}">Показ</label>
                                        </div>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @component('components.empty-records')
                    Поездок с вашим участием нет
                @endcomponent
            @endif
        </div>
    @endcomponent
@endsection