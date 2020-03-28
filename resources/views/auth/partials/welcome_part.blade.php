<a href="{{ url('/') }}" class="tt-block-title">
    <img src="{{ asset('images/logo.png') }}" alt="Logo img">

    @if (isset($title) && $title !== false)
        <div class="tt-title">
            {!! $title !!}
        </div>
    @endif
    @if (isset($description) && $description !== false)
        <div class="tt-description">
            {!! $description !!}
        </div>
    @endif
</a>
