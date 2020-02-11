@component('profiles.activities.activity')
<<<<<<< HEAD
    @slot('heading')
{{--        {{ $profileUser->name }} published--}}
{{--        <a href="{{ $activity->subject->path() }}">--}}
{{--            {{ $activity->subject->title }}--}}
{{--        </a>--}}
            <img class="tt-icon" src="{{ asset('images/svg-sprite/icon-ava-' . strtolower(substr($profileUser->name, 0, 1)) . '.svg') }}" alt="">
    @endslot

    @slot('body')
        <div class="tt-col-description">
            <h6>
                {{ $profileUser->name}} created a
                <a href="{{ $activity->subject->path() }}">
                {{ $activity->subject->title }}
                </a>
            </h6>
            <div class="tt-col-message">
{{--              @php(dd($activity))--}}
    {{--            {!! $activity->subject->body !!}--}}
            </div>
        </div>
    @endslot
    @slot('meta')
        <div class="tt-col-category"><span class="tt-color{{ $activity->subject->channel->id }} tt-badge">{{ $activity->subject->channel->name }}</span></div>
        <div class="tt-col-value hide-mobile">{{ $activity->subject->created_at->diffForHumans() }}</div>
=======
    @slot('avatar')
        <img class="tt-icon"
             src="{{ $activity->subject->creator->avatar_path }}"
             alt="{{ $activity->subject->creator->name }}">
    @endslot

    @slot('body')
        <h6 class="tt-title">
            {{ $profileUser->name }} published
            <a href="{{ $activity->subject->path() }}">
                {{ $activity->subject->title }}
            </a>
        </h6>
        <div class="tt-col-message">
            {!! $activity->subject->body !!}
        </div>
    @endslot

    @slot('channel')
        <span class="tt-color{{ $activity->subject->channel->id }} tt-badge">
            {{ $activity->subject->channel->name }}
        </span>
    @endslot

    @slot('statusIcon')
        <i class="tt-icon"><svg><use xlink:href="#icon-pencil"></use></svg></i>
    @endslot

    @slot('date')
        {{ $activity->created_at->format('d M,y') }}
>>>>>>> dev
    @endslot
@endcomponent
