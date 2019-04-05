@component('mail::message')
    # Появился новый комментарий к твоему объявлению


    @component('mail::button', ['url' => route('trip.show', ['trips' => $reply->trip->id])])
        Перейти к объявлению
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
