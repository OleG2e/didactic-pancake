<article class="message {{$type}}">
    <div class="message-header has-text-centered">
        <p class="is-center">{{$header}}</p>
    </div>
    <div class="message-body">
        {{ $slot }}
    </div>
</article>