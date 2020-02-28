@component('profiles.activities.activity')
    @slot('avatar')
        <img class="tt-icon"
             src="{{ $activity->subject->thread->creator->avatar_path }}"
             alt="{{ $activity->subject->thread->creator->name }}">
    @endslot

    @slot('body')
        <h6 class="tt-title">
            <a href="{{ $activity->subject->thread->path() }}">
                "{{ $activity->subject->thread->title }}"
            </a>
        </h6>
        <div class="tt-col-message">
            <a href="#">{{ $profileUser->name }} @lang('profiles.replied')</a> {!! $activity->subject->body !!}
        </div>
    @endslot

    @slot('channel')
        <span class="tt-color{{ $activity->subject->thread->channel->id }} tt-badge">
            {{ $activity->subject->thread->channel->name }}
        </span>
    @endslot

    @slot('statusIcon')
        <i class="tt-icon"><svg><use xlink:href="#icon-reply"></use></svg></i>
    @endslot

    @slot('date')
        {{ $activity->created_at->format('d M,y') }}
    @endslot
@endcomponent
