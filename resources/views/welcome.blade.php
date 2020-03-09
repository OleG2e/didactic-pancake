@extends('layouts.app')
@section('title', 'Микуньский информационный сайт')
@section('og:title', 'Микуньский информационный сайт')
@section('content')
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">
                    Микуньский информационный сайт
                </h1>
                <h2 class="subtitle">
                    <a href="{{ route('register') }}" class="button is-primary is-inverted is-outlined">Зарегистрироваться</a>
                </h2>
            </div>
        </div>
    </section>
    @if($allPosts->isNotEmpty())
        <div class="container box has-text-centered">
            <h4 class="title is-4 is-center">Последние 10 объявлений:</h4>
            <div class="columns">
                @foreach($allPosts as $postsCategory)
                    <div class="column">
                        <div class="box">
                            @foreach($postsCategory as $post)
                                @break($loop->iteration == 11)
                                @if($loop->first)
                                    <h5 class="title is-5">{{$post->category->title}}</h5>
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
