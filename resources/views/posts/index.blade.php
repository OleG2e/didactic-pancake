@extends('layouts.app')
@section('title', 'Объявления')
@section('og:title', 'Объявления')
@section('content')
    @component('components.hero')
        @if (session('message'))
            @component('components.flash-message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        @include('components.posts-nav')
        @auth
            <nav class="level">
                <div class="level-item level-left">
                    <a class="button is-primary is-rounded" href="{{route('post.create')}}">Создать объявление</a>
                </div>
            </nav>
        @endauth
        @if(count($posts))
            <div class="columns is-multiline">
                @foreach($posts as $post)
                    <div class="column is-narrow is-one-quarter">
                        <div class="box">
                            <p class="title is-size-5">{{$post->title}}</p>
                            <p class="subtitle is-size-5"><strong>{{$post->owner->username}}</strong>
                                <br>
                                <small class="is-size-6">{{$post->updated_at->diffForHumans()}}</small>
                            </p>
                            <div class="content">
                                @if ($post->countImages())
                                    <figure class="image is-4by3">
                                        <img class="js-image" src="{{\App\Helpers::getImage($post, 'preview')}}">
                                    </figure>
                                @endif
                                <span>{{\Illuminate\Support\Str::words($post->description, 10)}}</span>
                                <br>
                                <a href="{{route('post.show', [$post->category->slug, $post])}}">Подробнее</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @include('components.links', ['model' => $posts])
        @else
            @component('components.empty-records')
                Объявлений нет...
            @endcomponent
        @endif
    @endcomponent
@endsection