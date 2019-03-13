@extends('layouts.app')
@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container is-fluid box">
                {{ Breadcrumbs::render('post_all') }}
                @if (session('message'))
                    <div class="alert alert-success">
                        {{session('message')}}
                    </div>
                @endif
                <div class="columns is-multiline">
                    @foreach($posts as $post)
                        <div class="column is-narrow">
                            <div class="box" style="width: 250px">
                                <p class="title">{{$post->category->title}}</p>
                                <p class="subtitle"><strong>{{$post->owner->name}}</strong>
                                    <small> {{$post->created_at}}</small>
                                </p>
                                <div class="content">
                                    <p>
                                    <div class="more">{{$post->description}}</div>
                                    <a href="/posts/{{$post->id}}">
                                        Обсудить
                                    </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="control">
                    <a class="button is-primary" href="/posts/create">Создать объявление</a>
                </div>
            </div>
        </div>
    </section>
@endsection