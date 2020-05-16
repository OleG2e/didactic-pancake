@extends('layouts.app')
@section('title', 'Детали объявления')
@section('og:title', $post->title)
@if ($post->countImages())
    @section('og:image', \App\Helpers::getImage($post, 'preview'))
@endif
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post.show', $post->category, $post) }}
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
                        <p>
                            <strong>{{$post->owner->username}}</strong>
                            <small>{{$post->updated_at->diffForHumans()}}</small>
                            <br>
                            {{$post->description}}
                        </p>
                    </div>
                    @auth
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <a title="Связаться" class="level-item"
                                   onclick="event.preventDefault();$('#connect-post-form').submit();">
                                    <span class="icon is-small">
                                        <i class="fa fa-link"></i>
                                    </span>
                                </a>
                                @can('update', $post)
                                    <a title="Редактировать" class="level-item"
                                       href="{{route('post.edit', [$post->category->slug, $post])}}">
                                        <span class="icon is-small">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                    </a>
                                    <a title="Удалить" class="level-item"
                                       onclick="event.preventDefault();$('#delete-post-form').submit();">
                                        <span class="icon is-small">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </a>
                                @endcan
                            </div>
                        </nav>
                    @endauth
                    @if ($post->countImages())
                        <div class="level is-mobile">
                            @if ($post->countImages())
                                <div class="level-left">
                                    <div class="level-item">
                                        <script>
                                            function dropdownToggle() {
                                                if ($('.dropdown').hasClass('is-active')) {
                                                    $('.dropdown').removeClass('is-active');
                                                } else {
                                                    $('.dropdown').addClass('is-active');
                                                }
                                            }
                                        </script>
                                        <div class="dropdown">
                                            <div class="dropdown-trigger" onclick="dropdownToggle()">
                                                <button class="button">
                                                    <span>Фото</span>
                                                    <span class="icon is-small">
                                                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                                                </span>
                                                </button>
                                            </div>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-content">
                                                    @for ($i = 0; $i < $post->countImages(); $i++)
                                                        <div class="dropdown-item">
                                                            <figure class="image is-2by1 is-flex">
                                                                <img class="js-image"
                                                                     src="{{\App\Helpers::getImage($post, 'preview', $i)}}">
                                                            </figure>
                                                        </div>
                                                        @if($i < $post->countImages() - 1)
                                                            <hr class="dropdown-divider">
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if ($post->point->id)
                        <div class="field">
                            <script>
                                $(function () {
                                    window.ready = $('#map').css('display', 'none');
                                });
                            </script>
                            <label class="checkbox">
                                <input type="checkbox" id="checkbox" onclick="toggle()">Показать точку на карте
                            </label>
                            @include('components.ymap-points')
                        </div>
                    @endif
                    @include('components.reply', ['model_name' => \App\Post::MODEL_NAME, 'model_id' => $post->id])
                </div>
            </article>
        </div>
        @include('components.links', ['model' => $post])
        @include('components.reply-form', ['model_name' => \App\Post::MODEL_NAME, 'model_id' => $post->id])
        <a class="button is-info is-hovered" href="{{route('post.all', 'all')}}">Все объявления</a>
    @endcomponent
    <form id="delete-post-form" method="post" action="{{route('post.destroy', [$post->category->slug, $post])}}">
        @method('delete')
        @csrf
    </form>
    <form id="connect-post-form" method="post" action="{{route('post.link.request', [$post->category->slug, $post])}}">
        @csrf
    </form>
@endsection