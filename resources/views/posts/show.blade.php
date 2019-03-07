@extends('layouts.app')
@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container is-fluid">
                {{ Breadcrumbs::render('post_show', $post) }}
                <div class="box">
                    <article class="media">
                        <figure class="media-left">
                            <p class="image is-64x64">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </p>
                        </figure>
                        <div class="media-content">
                            <div class="content">
                                <p style="word-wrap: break-word;">

                                    <strong>{{$post->owner->name}}</strong>
                                    <small>{{$post->updated_at}}</small>
                                    <br>
                                    {{$post->description}}
                                    {{--<p style="word-wrap: break-word;">{{$post->description}}</p>--}}
                                </p>
                            </div>
                            <nav class="level is-mobile">
                                <div class="level-left">
                                    <div class="buttons are-small">
                                        <a class="button" href="/posts/{{$post->id}}/edit">
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
                            @foreach($post->replies as $reply)
                                <article class="media">
                                    <figure class="media-left">
                                        <p class="image is-48x48">
                                            <img src="https://bulma.io/images/placeholders/96x96.png">
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
                                            <a class="button"
                                               href="/posts/{{$reply->id}}/edit">
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
                                                      placeholder="Add a comment..."></textarea>
                                            </p>
                                        </div>
                                        <nav class="level">
                                            <div class="level-left">
                                                <div class="level-item">
                                                    <button class="button is-info" type="submit">Submit</button>
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
            </div>
        </div>
    </section>
    <form id="delete-post-form" method="post" action="/posts/{{$post->id}}">
        @method('delete')
        @csrf
    </form>
@endsection
