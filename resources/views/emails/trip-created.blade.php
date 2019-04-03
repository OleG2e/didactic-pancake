@component('mail::message')
    # Ваше объявление было опубликовано


    @component('mail::button', ['url' => route('trip_show', ['trips' => $trip->id])])
        Перейти к объявлению
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
