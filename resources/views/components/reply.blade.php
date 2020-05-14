@php($model = \App\Reply::getCurrentParentModel($model_name, $model_id))
@foreach($model->replies() as $reply)
    @php($routeParameters = [$model_name, $reply->parent($model_name)->id, $reply])
    <article class="media">
        <figure class="media-left">
            <p class="image is-48x48">
                <img src="{{$reply->owner->avatar()}}" alt="{{$reply->owner->username}}">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <strong>{{$reply->owner->username}}</strong>
                    <small>{{\App\Helpers::dateFormat($reply->updated_at)}}</small>
                    <br>
                    {{$reply->description}}
                </p>
            </div>
            @auth
                <nav class="level is-mobile">
                    <div class="level-left">
                        <a title="Связаться" class="level-item"
                           onclick="preventDefault();$('#connect-reply-form-{{$reply->id}}').submit();">
                            <span class="icon is-small">
                                <i class="fa fa-link"></i>
                            </span>
                        </a>
                        @can('update', $reply)
                            <a title="Редактировать" class="level-item"
                               href="{{route('reply.edit', $routeParameters)}}">
                                <span class="icon is-small">
                                    <i class="fa fa-edit"></i>
                                </span>
                            </a>
                            <a title="Удалить" class="level-item"
                               onclick="preventDefault();$('#delete-reply-form-{{$reply->id}}').submit();">
                                <span class="icon is-small">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </a>
                        @endcan
                    </div>
                </nav>
            @endauth
        </div>
    </article>
    <form id="delete-reply-form-{{$reply->id}}" method="post"
          action="{{route('reply.destroy', $routeParameters)}}">
        @method('delete')
        @csrf
    </form>
    <form id="connect-reply-form-{{$reply->id}}" method="post"
          action="{{route('reply.link.request', $routeParameters)}}">
        @csrf
    </form>
@endforeach