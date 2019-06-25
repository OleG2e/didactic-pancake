@foreach($post->replies() as $reply)
    <article class="media">
        <figure class="media-left">
            <p class="image is-48x48">
                <img src="{{$reply->owner->avatar()}}" alt="{{$reply->owner->name}}">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <div style="white-space:pre-line">
                    <strong>{{$reply->owner->name}}</strong>
                    <small>{{$reply->updated_at}}</small>
                    <br><span>{{$reply->description}}</span>
                    @auth
                        <form method="post" action="{{route('reply.link.request', $reply)}}">
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
            </div>
            @can('update', $reply)
                <div class="field is-grouped">
                    <a class="button is-small" href="{{route('reply.edit',$reply)}}">
                        <span class="icon is-small">
                            <i class="fa fa-edit"></i>
                        </span>
                    </a>
                    <form method="post" action="{{route('reply.destroy',$reply)}}">
                        @method('delete')
                        @csrf
                        <button class="button is-small" type="submit">
                            <span class="icon is-small">
                                <i class="fa fa-trash"></i>
                            </span>
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </article>
@endforeach