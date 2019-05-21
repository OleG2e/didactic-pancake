@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('trip.show', $trip) }}
        @if (session('message'))
            @component('components.flash_message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        <div class="box">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img src="{{$trip->owner->avatar()}}" alt="{{$trip->owner->name}}">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        @php
                            $dateTime = new DateTime($trip->date_time);
                        @endphp
                        <strong>{{$trip->owner->name}}</strong>
                        <small>{{$trip->updated_at->diffForHumans()}}</small>
                        @isset($trip->description)<br>Описание: {{$trip->description}}@endisset
                        <br><span>{{$trip->startpoint->title}} - {{$trip->endpoint->title}}</span>
                        <br>Дата поездки: {{$dateTime->format('d.m.Y H:i')}}
                        @if($trip->passengers_count)<br>Осталось мест: {{$trip->passengers_count}}@endif
                        <br> Стоимость: {{$trip->price}}
                        @auth
                            @if (count($trip->users)==false and $trip->owner->id !== auth()->id())
                                <form method="post" action="{{route('add.user', $trip)}}">
                                    @method('patch')
                                    @csrf
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" class="button is-primary">Я поеду!</button>
                                        </div>
                                    </div>
                                </form>
                            @elseif(count($trip->users) and $trip->owner->id !== auth()->id())
                                @if (count($trip->users()->where('user_id',auth()->id())->get()))
                                    <form method="post" action="{{route('remove.user', $trip)}}">
                                        @method('delete')
                                        @csrf
                                        <div class="field">
                                            <div class="control">
                                                <button type="submit" class="button is-danger">Я передумал ехать!
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <form method="post" action="{{route('add.user', $trip)}}">
                                        @method('patch')
                                        @csrf
                                        <div class="field">
                                            <div class="control">
                                                <button type="submit" class="button is-primary">Я поеду!</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            @endif
                        @endauth
                    </div>
                    @can('update', $trip)
                        <a class="button is-small" href="{{route('trip.edit',$trip)}}">
                            <span class="icon is-small">
                                <i class="fa fa-edit"></i>
                            </span>
                        </a>
                        <a class="button is-small" onclick="event.preventDefault();
                              document.getElementById('delete-trip-form').submit();">
                            <span class="icon is-small">
                                <i class="fa fa-trash"></i>
                            </span>
                        </a>
                    @endcan
                    @include('subview.reply', ['post' => $trip])
                </div>
            </article>
            @include('subview.reply-form', ['post' => $trip])
            <br>
            <a class="button is-info is-hovered" href="{{route('trip.all')}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-trip-form" method="post" action="{{route('trip.destroy',$trip)}}">
        @method('delete')
        @csrf
    </form>
@endsection