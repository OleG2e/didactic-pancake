@auth
    <section class="section">
        <article class="media">
            <div class="media-content">
                <form action="{{route('reply.store', [$model_name,$model_id])}}" method="post">
                    @csrf
                    <article class="media">
                        <figure class="media-left is-hidden-touch">
                            <p class="image is-64x64">
                                <img class="is-rounded"
                                     src="{{Auth::user()->avatar()}}" alt="{{Auth::user()->username}}">
                            </p>
                        </figure>
                        <div class="media-content">
                            <div class="field">
                                <p class="control">
                                        <textarea class="textarea" name="description"
                                                  placeholder="Комментарий..."></textarea>
                                </p>
                            </div>
                            <nav class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        <button class="button is-primary is-rounded" type="submit">Ответить</button>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </article>
                </form>
            </div>
        </article>
    </section>
@endauth