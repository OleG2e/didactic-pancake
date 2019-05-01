@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post.show', $post) }}
        @if (session('message'))
            @component('components.flash_message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        <div class="box">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img src="{{$post->owner->avatar()}}" alt="{{$post->owner->name}}">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p style="word-wrap: break-word;">
                            <strong>{{$post->owner->name}}</strong>
                            <small>{{$post->updated_at->diffForHumans()}}</small>
                            @auth
                                <a title="Связаться" class="button is-small"
                                   href="{{route('post.link.request', $post)}}">
                                    <span class="icon is-small">
                                        <i class="fas fa-link"></i>
                                    </span>
                                </a>
                            @endauth
                            <br>
                            {{$post->description}}
                        </p>
                    </div>
                    <nav class="level is-mobile">
                        <div class="level-left">
                            <div class="buttons are-small">
                                @can('update', $post)
                                    <a title="Редактировать" class="button" href="{{route('post.edit', $post)}}">
                                    <span class="icon is-small">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    </a>
                                    <a title="Удалить" class="button" onclick="event.preventDefault();
                                        document.getElementById('delete-post-form').submit();">
                                            <span class="icon is-small">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </nav>
                    @if (isset($post->images))
                        @for ($i = 0; $i < count($imagesAll->full); $i++)
                            <figure class="image is-128x128" style="display: inline-block">
                                <a href="{{asset($imagesAll->full[$i])}}">
                                    <img src="{{asset($imagesAll->preview[$i])}}"></a>
                            </figure>
                        @endfor
                    @endif
                    @foreach($post->replies as $reply)
                        <article class="media">
                            <figure class="media-left">
                                <p class="image is-48x48">
                                    <img src="{{$reply->owner->avatar()}}" alt="{{$reply->owner->name}}">
                                </p>
                            </figure>
                            <div class="media-content">
                                <div class="content">
                                    <p style="word-wrap: break-word;">
                                        <strong>{{$reply->owner->name}}</strong>
                                        <small>{{$reply->updated_at}}</small>
                                        @auth
                                            <a title="Связаться" class="button is-small"
                                               href="{{route('reply.post.link.request', $reply)}}">
                                            <span class="icon is-small">
                                                <i class="fas fa-link"></i>
                                            </span>
                                            </a>
                                        @endauth
                                        <br>
                                        {{$reply->description}}
                                    </p>
                                </div>
                                <div class="buttons are-small">
                                    @can('update', $post)
                                        <a title="Редактировать" class="button"
                                           href="{{route('reply.post.edit', $reply)}}">
                                                <span class="icon is-small">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                        </a>
                                        <form method="post" action="{{route('reply.trip.destroy', $reply)}}">
                                            @method('delete')
                                            @csrf
                                            <button title="Удалить" class="button" type="submit">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </article>
            @auth
                <article class="media">
                    <div class="media-content">
                        <form action="{{route('reply.post.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <article class="media">
                                <figure class="media-left">
                                    <p class="image is-64x64">
                                        <img class="is-rounded"
                                             src="{{Auth::user()->avatar()}}" alt="{{Auth::user()->name}}">
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
            <a class="button is-info is-hovered" href="{{route('post.all')}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-post-form" method="post" action="{{route('post.destroy', $post)}}">
        @method('delete')
        @csrf
    </form>
@endsection
