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
                    @if ($reply->edited)
                        <small class="is-size-7">(ответ отредактирован)</small>
                    @endif
                    @auth
                        <a title="Связаться" class="modal-button"
                           data-target="modal-bis-reply-connect-{{$reply->id}}">
                            <span class="icon is-small">
                                <i class="fa fa-link"></i>
                            </span>
                        </a>
                    @endauth
                    <br>
                    {{$reply->description}}
                </p>
            </div>
            @auth
                <div class="modal" id="modal-bis-reply-connect-{{$reply->id}}">
                    <div class="modal-background"></div>
                    <div class="modal-card">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Связаться с {{$reply->owner->username}}?</p>
                            <button class="delete" aria-label="close"></button>
                        </header>
                        <section class="modal-card-body">
                            Отправить ваши анкетные данные для связи пользователю {{$reply->owner->username}}?
                        </section>
                        <footer class="modal-card-foot">
                            <form method="post"
                                  action="{{route('reply.link.request', $routeParameters)}}">
                                @csrf
                                <button class="button is-primary" type="submit">
                                            <span class="icon is-small">
                                                <i class="fas fa-paper-plane" aria-hidden="true"></i>
                                            </span>
                                    <span>Отправить</span>
                                </button>
                                <a class="button is-info">Отмена</a>
                            </form>
                        </footer>
                    </div>
                </div>
                @can('update', $reply)
                    <nav class="level is-mobile">
                        <div class="level-left">
                            <a title="Редактировать" class="level-item"
                               href="{{route('reply.edit', $routeParameters)}}">
                                <span class="icon is-small">
                                    <i class="fa fa-edit"></i>
                                </span>
                            </a>
                            <a title="Удалить" class="level-item modal-button"
                               data-target="modal-bis-reply-remove-{{$reply->id}}">
                                <span class="icon is-small">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </a>
                            <div class="modal" id="modal-bis-reply-remove-{{$reply->id}}">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                        <p class="modal-card-title">Подтверди удаление</p>
                                        <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Удалить ответ {{$reply->description}}?
                                    </section>
                                    <footer class="modal-card-foot">
                                        <form method="post"
                                              action="{{route('reply.destroy', $routeParameters)}}">
                                            @method('delete')
                                            @csrf
                                            <button class="button is-danger" type="submit">
                                                <span class="icon is-small">
                                                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                                </span>
                                                <span>Удалить!</span>
                                            </button>
                                            <a class="button is-info">Отмена</a>
                                        </form>
                                    </footer>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </nav>
                @endauth
        </div>
    </article>
@endforeach