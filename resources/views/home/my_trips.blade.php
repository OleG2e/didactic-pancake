@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post.all') }}
        @if (session('message'))
            @component('components.flash_message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        @include('subview.home-nav')
        <nav class="level">
            <div class="level-item level-left">
                <div class="control">
                    <p class="title">Мои поездки:</p>
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
                        <div class="box"
                             style="width: 250px; background-color: {{$trip->relevance ? 'hsl(171, 100%, 41%)' : 'hsl(48, 100%, 67%)'}}">
                            <div class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        <p class="title">{{$trip->category->title}}</p>
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
                            <p class="title">{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</p>
                            <p class="subtitle"><strong>{{$trip->owner->name}}</strong>
                                <small> {{$trip->created_at}}</small>
                            </p>
                            <div class="content">
                                <a href="{{route('trip.show', $trip)}}">
                                    Обсудить
                                </a>
                                @can('update', $trip)
                                    <form method="post" action="{{route('update.relevance.trip', $trip)}}">
                                        @method('patch')
                                        @csrf
                                        <label class="checkbox">
                                            <input type="checkbox" name="relevance"
                                                   onchange="this.form.submit()" {{$trip->relevance ? 'checked' : ''}}>
                                            Показывать
                                        </label>
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