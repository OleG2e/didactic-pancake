@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('trip_show', $trip) }}
        <div class="box">
            @if (session('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
            @endif
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
                            мест: {{$trip->passengers_count - $trip->users()->count()}}@endif
                            @if($trip->load)<br>Есть место для груза@endif
                        </p>
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
                                            <button type="submit" class="button is-danger">Я передумал ехать!</button>
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
                    </div>
                    <nav class="level is-mobile">
                        <div class="level-left">
                            <div class="buttons are-small">
                                <a class="button" href="/trips/{{$trip->id}}/edit">
                                    <span class="icon is-small">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </a>
                                <a class="button" onclick="event.preventDefault();
                                        document.getElementById('delete-post-form').submit();">
                                    <span class="icon is-small">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </nav>
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
                                <div class="buttons are-small">
                                    <a class="button" href="/replies/{{$reply->id}}/edit">
                                        <span class="icon is-small">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a>
                                    <form method="post" action="/replies/{{$reply->id}}">
                                        @method('delete')
                                        @csrf
                                        <button class="button" type="submit">
                                            <span class="icon is-small">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </article>
            <article class="media">
                <div class="media-content">
                    <form action="/replies" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$trip->id}}">
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
                                            <button class="button is-primary is-rounded" type="submit">Ответить</button>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </article>
                    </form>
                </div>
            </article>
            <a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-post-form" method="post" action="/trips/{{$trip->id}}">
        @method('delete')
        @csrf
    </form>
@endsection