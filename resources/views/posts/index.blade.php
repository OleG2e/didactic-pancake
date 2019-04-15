@extends('layouts.app')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('post.all') }}
        @if (session('message'))
            @component('components.flash_message', ['type'=>'is-success'])
                {{ session('message') }}
            @endcomponent
        @endif
        @auth
            <nav class="level">
                <div class="level-item level-left">
                    <a class="button is-primary is-rounded" href="{{route('post.create')}}">Создать объявление</a>
                </div>
            </nav>
        @endauth
        <div class="columns is-multiline">
            @foreach($posts as $post)
                <div class="column is-narrow">
                    <div class="box" style="width: 250px">
                        <p class="title">{{$post->category->title}}</p>
                        <p class="subtitle"><strong>{{$post->owner->name}}</strong>
                            <small> {{$post->updated_at->diffForHumans()}}</small>
                        </p>
                        <div class="content">
                            <div class="more">{{$post->description}}</div>
                            <a href="{{route('post.show', $post)}}">
                                Обсудить
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endcomponent
@endsection