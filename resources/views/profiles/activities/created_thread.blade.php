@component('profiles.activities.activity')
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
        <div class="tt-col-value hide-mobile">{{ $activity->subject->created_at }}</div>
    @endslot
@endcomponent
