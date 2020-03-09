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
        <div class="columns is-multiline">
            @if(count($posts))
                @foreach($posts as $post)
                    <div class="column is-narrow">
                        <div class="box" style="width: 250px">
                            @if (\App\AppTemplate::currentCategory() === 'all')
                                <p class="title is-size-4">{{$post->category->title}}</p>
                            @endif
                            <p class="subtitle"><strong>{{$post->owner->name}}</strong>
                                <small> {{$post->updated_at->diffForHumans()}}</small>
                            </p>
                            <div class="content">
                                <div class="more">{{$post->description}}</div>
                                <a href="{{route('post.show', [$post->category->slug, $post])}}">
                                    Обсудить
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <footer class="container">{{ $posts->links() }}</footer>
            @else
                @component('components.empty-records')
                    Объявлений нет...
                @endcomponent
            @endif
        </div>
    @endcomponent
@endsection