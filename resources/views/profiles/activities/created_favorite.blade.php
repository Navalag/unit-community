@component('profiles.activities.activity')
    @slot('heading')
        <img class="tt-icon" src="{{ asset('images/svg-sprite/icon-ava-' . strtolower(substr($profileUser->name, 0, 1)) . '.svg') }}" alt="">
    @endslot

    @slot('body')
{{--        {!! $activity->subject->favorited->body !!}--}}

        <div class="tt-col-description">
            <h6>
                {{ $profileUser->name }} favorited
                <a href="{{ $activity->subject->favorited->path() }}">
                    a reply.
                </a>
            </h6>
            <div class="tt-col-message">
                {{--              @php(dd($activity))--}}
                {{--            {!! $activity->subject->body !!}--}}
            </div>
        </div>
{{--        @php(dd($activity))--}}
    @endslot

    @slot('meta')
    <div class="tt-col-category"><span class="tt-color{{ $activity->subject->favorited->thread->channel->id }} tt-badge">{{ $activity->subject->favorited->thread->channel->name }}</span></div>
    <div class="tt-col-value hide-mobile">{{ $activity->created_at }}</div>
    @endslot
@endcomponent
