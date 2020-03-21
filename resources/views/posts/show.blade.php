@extends('layouts.app')
@section('title', 'Детали объявления')
@section('og:title', $post->title)
@if ($post->countImages())
    @section('og:image', \App\Helpers::getImage($post, 'preview'))
@endif
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post.show', $post->category->slug, $post) }}
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        <div class="box">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img src="{{$post->owner->avatar()}}" alt="{{$post->owner->username}}">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <div style="white-space:pre-line">
                            <strong>{{$post->owner->username}}</strong>
                            <small>{{$post->updated_at->diffForHumans()}}</small>
                            <br><span>{{$post->description}}</span>
                            @auth
                                <form method="post"
                                      action="{{route('post.link.request', [$post->category->slug, $post])}}">
                                    @csrf
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" title="Связаться" class="button is-small">
                                            <span class="icon is-small">
                                                <i class="fa fa-link"></i>
                                            </span>
                                                <span>Связаться</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endauth
                        </div>
                        @can('update', $post)
                            <a title="Редактировать" class="button is-small"
                               href="{{route('post.edit', [$post->category->slug, $post])}}">
                            <span class="icon is-small">
                                <i class="fa fa-edit"></i>
                            </span>
                            </a>
                            <a title="Удалить" class="button is-small" onclick="event.preventDefault();
                           document.getElementById('delete-post-form').submit();">
                            <span class="icon is-small">
                                <i class="fa fa-trash"></i>
                            </span>
                            </a>
                        @endcan
                    </div>
                    @if ($post->countImages())
                        @for ($i = 0; $i < $post->countImages(); $i++)
                            <figure class="image is-128x128" style="display: inline-block">
                                <a href="{{\App\Helpers::getImage($post, 'full', $i)}}" target="_blank">
                                    <img src="{{\App\Helpers::getImage($post, 'preview', $i)}}">
                                </a>
                            </figure>
                        @endfor
                    @endif
                    @include('components.reply', ['model_name' => \App\Post::MODEL_NAME, 'model_id' => $post->id])
                </div>
            </article>
            <section class="section">
                @include('components.reply-form', ['model_name' => \App\Post::MODEL_NAME, 'model_id' => $post->id])
            </section>
            <div class="container">{{ $post->replies()->links() }}</div>
            <br><a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-post-form" method="post" action="{{route('post.destroy', [$post->category->slug, $post])}}">
        @method('delete')
        @csrf
    </form>
@endsection
