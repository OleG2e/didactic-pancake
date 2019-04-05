@component('mail::message')
    # Вы отказались от поездки


    @component('mail::button', ['url' => route('trip.show', ['trips' => $trip->id])])
        Перейти к объявлению
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
