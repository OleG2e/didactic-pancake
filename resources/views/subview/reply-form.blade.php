@auth
    <article class="media">
        <div class="media-content">
            <form action="{{route('reply.store')}}" method="post">
                @csrf
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <input type="hidden" name="category_id" value="{{$post->category_id}}">
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-64x64">
                            <img class="is-rounded"
                                 src="{{Auth::user()->avatar()}}" alt="{{Auth::user()->name}}">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="field">
                            <p class="control">
                                        <textarea class="textarea" name="description" cols="6" rows="3"
                                                  placeholder="Комментарий..."></textarea>
                            </p>
                        </div>
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <button class="button is-primary is-rounded" type="submit">Ответить
                                    </button>
                                </div>
                            </div>
                        </nav>
                    </div>
                </article>
            </form>
        </div>
    </article>
@endauth