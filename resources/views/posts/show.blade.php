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
                        <img src="{{asset('/storage/avatars/'.$post->owner->id.'/avatar.jpg')}}">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p style="word-wrap: break-word;">
                            <strong>{{$post->owner->name}}</strong>
                            <small>{{$post->updated_at->diffForHumans()}}</small>
                            <br>
                            {{$post->description}}
                        </p>
                    </div>
                    @can('update', $post)
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <div class="buttons are-small">
                                    <a class="button" href="{{route('post.edit', $post)}}">
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
                    @endcan
                    @foreach($post->replies as $reply)
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
                                @can('update', $post)
                                    <div class="buttons are-small">
                                        <a class="button" href="{{route('reply.post.edit', $reply)}}">
                                                <span class="icon is-small">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                        </a>
                                        <form method="post" action="{{route('reply.trip.destroy', $reply)}}">
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
                    <form action="{{route('reply.post.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <article class="media">
                            <figure class="media-left">
                                <p class="image is-64x64">
                                    <img class="is-rounded"
                                         src="https://bulma.io/images/placeholders/128x128.png">
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
            @endauth
            <br>
            <a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-post-form" method="post" action="{{route('post.destroy', $post)}}">
        @method('delete')
        @csrf
    </form>
@endsection
