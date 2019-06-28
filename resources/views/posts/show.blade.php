@extends('layouts.app')
@section('title', 'Детали объявления')
@section('og:title', $post->title)
@if (!empty($imagesAll))
    @section('og:image', asset($imagesAll->preview[0]))
@endif
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post.show', $post) }}
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
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
                        <div style="white-space:pre-line">
                            <strong>{{$post->owner->name}}</strong>
                            <small>{{$post->updated_at->diffForHumans()}}</small>
                            <br><span>{{$post->description}}</span>
                            @auth
                                <form method="post" action="{{route('post.link.request', $post)}}">
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
                               href="{{route('post.edit', $post)}}">
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
                    @if (!empty($imagesAll))
                        @for ($i = 0; $i < count($imagesAll->full); $i++)
                            <figure class="image is-128x128" style="display: inline-block">
                                <a href="{{asset($imagesAll->full[$i])}}">
                                    <img src="{{asset($imagesAll->preview[$i])}}"></a>
                            </figure>
                        @endfor
                    @endif
                    @include('components.reply', $post)
                </div>
            </article>
            <section class="section">
                @include('components.reply-form', $post)
            </section>
            <div class="container">{{ $post->replies()->links() }}</div>
            <br><a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
        </div>
    @endcomponent
    <form id="delete-post-form" method="post" action="{{route('post.destroy', $post)}}">
        @method('delete')
        @csrf
    </form>
@endsection
