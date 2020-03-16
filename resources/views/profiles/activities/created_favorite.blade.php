@component('profiles.activities.activity')
    @slot('avatar')
        <a href="{{ LaravelLocalization::localizeUrl('profiles/' . $activity->subject->favorited->owner->name) }}">
            <img class="tt-icon"
                 src="{{ $activity->subject->favorited->owner->avatar_path }}"
                 alt="{{ $activity->subject->favorited->owner->name }}">
        </a>
    @endslot

    @slot('body')
        <h6 class="tt-title">
            <a href="{{ $activity->subject->favorited->path() }}">
                {{ $profileUser->name }} @lang('profiles.favorited_a_reply')
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
    @endslot
@endcomponent
