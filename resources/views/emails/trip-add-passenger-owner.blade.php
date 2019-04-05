@component('mail::message')
    # У вас появился новый пассажир


    @component('mail::button', ['url' => route('trip.show', ['trips' => $trip->id])])
        Перейти к объявлению
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
