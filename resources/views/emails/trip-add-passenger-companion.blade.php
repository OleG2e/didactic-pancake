@component('mail::message')
    # Вы присоединились к поездке


    @component('mail::button', ['url' => route('trip.show', ['trips' => $trip->id])])
        Перейти к объявлению
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
