@component('profiles.activities.activity')
    @slot('heading')

        <img class="tt-icon" src="{{ asset('images/svg-sprite/icon-ava-' . strtolower(substr($profileUser->name, 0, 1)) . '.svg') }}" alt="">
    @endslot

    @slot('body')
        <div class="tt-col-description">
            <h6>
                {{ $profileUser->name }} replied to
                <a href="{{ $activity->subject->thread->path() }}">
                    "{{ $activity->subject->thread->title }}"
                </a>
            </h6>
            <div class="tt-col-message">
                {{--              @php(dd($activity))--}}
                {{--            {!! $activity->subject->body !!}--}}
            </div>
        </div>
{{--       @php(dd($activity))--}}

    @endslot
    @slot('meta')
            <div class="tt-col-category"><span class="tt-color{{ $activity->subject->thread->channel->id }} tt-badge">{{ $activity->subject->thread->channel->name }}</span></div>
            <div class="tt-col-value hide-mobile">{{ $activity->created_at }}</div>
    @endslot
@endcomponent
