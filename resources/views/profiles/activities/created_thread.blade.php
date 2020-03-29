@component('profiles.activities.activity')
    @slot('avatar')
        <a href="{{ LaravelLocalization::localizeUrl('profiles/' . $activity->subject->creator->name) }}">
            <img class="tt-icon"
                 src="{{ $activity->subject->creator->avatar_path }}"
                 alt="{{ $activity->subject->creator->name }}">
        </a>
    @endslot

    @slot('body')
        <h6 class="tt-title">
            {{ $profileUser->name }} @lang('profiles.published')
            <a href="{{ $activity->subject->path() }}">
                {{ $activity->subject->title }}
            </a>
        </h6>
        <div class="tt-col-message" v-html="{{ json_encode($activity->subject->body) }}"></div>
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
    @endslot
@endcomponent
