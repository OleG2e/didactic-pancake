@extends('layouts.app')
@section('title', 'Микуньский информационный сайт')
@section('og:title', 'Микуньский информационный сайт')
@section('content')
    <section class="hero is-success is-fullheight is-bold">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">
                    Микуньский информационный сайт
                </h1>
                @guest
                    <h2 class="subtitle">
                        <a href="{{ route('register') }}" class="button is-primary is-inverted is-outlined">Зарегистрироваться</a>
                    </h2>
                @endguest
                @include('components.ymap-points')
            </div>
        </div>
    </section>
    @if($posts->isNotEmpty())
        <div class="container box has-text-centered">
            <p class="title is-4 is-center">Новые объявления:</p>
            <div class="columns is-multiline">
                @foreach($posts as $postsCategory)
                    <div class="column is-one-quarter">
                        <div class="box">
                            @foreach($postsCategory as $post)
                                @break($loop->iteration == 6)
                                @if($loop->first)
                                    <p class="title is-5">{{$post->category->title}}</p>
                                @endif
                                <p>
                                    <strong>{{$loop->iteration}}.</strong>
                                    <a href="{{route('post.show', [$post->category->slug, $post->id])}}">{{$post->title}}</a>
                                </p>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
