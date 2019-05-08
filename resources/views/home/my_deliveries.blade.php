@extends('layouts.app')
@section('content')
    @component('components.hero')
        @if (session('message'))
            @component('components.flash_message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        @include('subview.home-nav')
        <nav class="level">
            <div class="level-item level-left">
                <div class="control">
                    <p class="title">Мои передачки:</p>
                </div>
            </div>
            <div class="level-item" style="padding-bottom: 10px">
                <a class="button is-primary is-rounded" href="{{route('delivery.create')}}">Создать передачку</a>
            </div>
        </nav>
        <div class="columns is-multiline">
            @if(count($myDeliveries))
                @foreach($myDeliveries as $trip)
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
                            <div class="modal" id="modal-bis-{{$trip->id}}">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                        <p class="modal-card-title">Подтвердите удаление</p>
                                        <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Удалить пост от {{$trip->created_at}}?
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
                            <p class="title">{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</p>
                            <p class="subtitle"><strong>{{$trip->owner->name}}</strong>
                                <small> {{$trip->created_at}}</small>
                            </p>
                            <div class="content">
                                <a href="{{route('delivery.show', $trip)}}">
                                    Обсудить
                                </a>
                                <form method="post" action="{{route('update.relevance.delivery', $trip)}}">
                                    @method('patch')
                                    @csrf
                                    <label class="checkbox">
                                        <input type="checkbox" name="relevance"
                                               onchange="this.form.submit()" {{$trip->relevance ? 'checked' : ''}}>
                                        Показывать
                                    </label>
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