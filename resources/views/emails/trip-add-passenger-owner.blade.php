@component('mail::message')
    # У вас появился новый пассажир {{$user->name}}.
    @isset($user->link) Связаться: {{$user->link}}@endisset


    @component('mail::button', ['url' => route('trip.show', ['trips' => $trip->id])])
        Перейти к объявлению
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
