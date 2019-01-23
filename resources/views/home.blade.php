@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        You are logged in!
                        <div> {{$user->about}}</div>
                        <div> {{$user->phone}}</div>
                        <form method="post" action="/home" class="form-control">
                            @csrf
                            <input type="number" name="phone" placeholder="Phone">
                            <textarea name="about" placeholder="Обо мне">{{$user->about}}</textarea>
                            <button type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
