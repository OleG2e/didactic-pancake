@component('mail::message')
    # Появился новый комментарий к твоему объявлению


    @component('mail::button', ['url' => route('post_show', ['posts' => $reply->post->id])])
        Перейти к объявлению
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
