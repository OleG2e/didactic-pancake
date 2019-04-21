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
                        <img src="{{asset('/storage/avatars/'.$trip->owner->id.'/avatar.jpg')}}">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        @php
                            $dateTime = new DateTime($trip->date_time);
                        @endphp
                        <p style="word-wrap: break-word;">
                            <strong>{{$trip->owner->name}}</strong>
                            <small>{{$trip->updated_at->diffForHumans()}}</small>
                            @isset($trip->description)<br> Описание: {{$trip->description}}@endisset
                            <br>Дата поездки: {{$dateTime->format('d.m.Y H:i')}}
                            @if($trip->passengers_count)<br>Осталось
                            мест: {{$trip->passengers_count}}@endif
                            @if($trip->load)<br>Есть место для груза@endif
                            <br> Стоимость: {{$trip->price}}
                        </p>
                        @auth
                            @if (count($trip->users)==false)
                                <form method="post" action="{{route('add.user', $trip)}}">
                                    @method('patch')
                                    @csrf
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" class="button is-primary">Я поеду!</button>
                                        </div>
                                    </div>
                                </form>
                            @elseif(count($trip->users))
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
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <div class="buttons are-small">
                                    <a class="button" href="{{route('trip.edit',$trip)}}">
                                    <span class="icon is-small">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    </a>
                                    <a class="button" onclick="event.preventDefault();
                                        document.getElementById('delete-trip-form').submit();">
                                    <span class="icon is-small">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    </a>
                                </div>
                            </div>
                        </nav>
                    @endcan
                    @foreach($trip->replies as $reply)
                        <article class="media">
                            <figure class="media-left">
                                <p class="image is-48x48">
                                    <img src="{{asset('/storage/avatars/'.$reply->owner->id.'/avatar.jpg')}}">
                                </p>
                            </figure>
                            <div class="media-content">
                                <div class="content">
                                    <p style="word-wrap: break-word;">
                                        <strong>{{$reply->owner->name}}</strong>
                                        <small>{{$reply->updated_at}}</small>
                                        <br>
                                        {{$reply->description}}
                                    </p>
                                </div>
                                @can('update', $reply)
                                    <div class="buttons are-small">
                                        <a class="button" href="{{route('reply.trip.edit',$reply)}}">
                                        <span class="icon is-small">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        </a>
                                        <form method="post" action="{{route('reply.trip.destroy',$reply)}}">
                                            @method('delete')
                                            @csrf
                                            <button class="button" type="submit">
                                            <span class="icon is-small">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                            </div>
                        </article>
                    @endforeach
                </div>
            </article>
                @auth
                    <article class="media">
                        <div class="media-content">
                            <form action="{{route('reply.trip.store')}}" method="post">
                                @csrf
                                <input type="hidden" name="trip_id" value="{{$trip->id}}">
                                <article class="media">
                                    <figure class="media-left">
                                        <p class="image is-64x64">
                                            <img class="is-rounded"
                                                 src="{{asset('/storage/avatars/'.auth()->id().'/avatar.jpg')}}">
                                        </p>
                                    </figure>
                                    <div class="media-content">
                                        <div class="field">
                                            <p class="control">
                                        <textarea class="textarea" name="description" cols="6" rows="3"
                                                  placeholder="Комментарий..."></textarea>
                                            </p>
                                        </div>
                                        <nav class="level">
                                            <div class="level-left">
                                                <div class="level-item">
                                                    <button class="button is-primary is-rounded" type="submit">Ответить
                                                    </button>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </article>
                            </form>
                        </div>
                    </article>
                @endauth
                <br>
            <a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-trip-form" method="post" action="{{route('trip.destroy',$trip)}}">
        @method('delete')
        @csrf
    </form>
@endsection