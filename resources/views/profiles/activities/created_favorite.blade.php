@component('profiles.activities.activity')
<<<<<<< HEAD
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
=======
    @slot('avatar')
        <img class="tt-icon"
             src="{{ $activity->subject->favorited->owner->avatar_path }}"
             alt="{{ $activity->subject->favorited->owner->name }}">
    @endslot

    @slot('body')
        <h6 class="tt-title">
            <a href="{{ $activity->subject->favorited->path() }}">
                {{ $profileUser->name }} favorited a reply.
            </a>
        </h6>
        <div class="tt-col-message">
            {!! $activity->subject->favorited->body !!}
        </div>
    @endslot

    @slot('channel')
        <span class="tt-color{{ $activity->subject->favorited->thread->channel->id }} tt-badge">
            {{ $activity->subject->favorited->thread->channel->name }}
        </span>
    @endslot

    @slot('statusIcon')
        <i class="tt-icon"><svg><use xlink:href="#icon-favorite"></use></svg></i>
    @endslot

    @slot('date')
        {{ $activity->created_at->format('d M,y') }}
>>>>>>> dev
    @endslot
@endcomponent
