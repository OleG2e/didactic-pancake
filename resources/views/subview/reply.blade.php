@foreach($post->replies() as $reply)
    <article class="media">
        <figure class="media-left">
            <p class="image is-48x48">
                <img src="{{$reply->owner->avatar()}}" alt="{{$reply->owner->name}}">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p style="word-wrap: break-word;">
                    <strong>{{$reply->owner->name}}</strong>
                    <small>{{$reply->updated_at}}</small>
                    @auth
                        <a title="Связаться" class="button is-small"
                           href="{{route('reply.link.request', $reply)}}">
                                            <span class="icon is-small">
                                                <i class="fa fa-link"></i>
                                            </span>
                        </a>
                    @endauth<br>
                    {{$reply->description}}
                </p>
            </div>
            @can('update', $reply)
                <div class="buttons are-small">
                    <a class="button" href="{{route('reply.edit',$reply)}}">
                                        <span class="icon is-small">
                                            <i class="fa fa-edit"></i>
                                        </span>
                    </a>
                    <form method="post" action="{{route('reply.destroy',$reply)}}">
                        @method('delete')
                        @csrf
                        <button class="button" type="submit">
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