<div class="tt-item @if($thread->is_trending) tt-itemselect @endif">
    <div class="tt-col-avatar">
        <a href="{{ LaravelLocalization::localizeUrl('/profiles/' . $thread->creator->name) }}">
            <img class="tt-icon" src="{{ $thread->creator->avatar_path }}" alt="">
        </a>
    </div>
    <div class="tt-col-description">
        <h6 class="tt-title">
            <a href="{{ $thread->path() }}">
                @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                    <strong>
                        {{ $thread->title }}
                    </strong>
                @else
                    {{ $thread->title }}
                @endif
            </a>
        </h6>
        <div class="row align-items-center no-gutters  hide-desktope">
            <div class="col-11">
                <ul class="tt-list-badge">
                    <li class="show-mobile">
                        <a href="{{ LaravelLocalization::localizeUrl('/threads/' . $thread->channel->slug) }}">
                            <span class="tt-color{{ $thread->channel->id }} tt-badge">{{ $thread->channel->name }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-1 ml-auto show-mobile">
                <div class="tt-value">{{ \Carbon\Carbon::parse($thread->updated_at)->diffForHumans(null, true, true)}}</div>
            </div>
        </div>
    </div>
    <div class="tt-col-category">
        <a class="tt-color{{ $thread->channel->id }} tt-badge"
           href="{{ LaravelLocalization::localizeUrl('/threads/' . $thread->channel->slug) }}">
            {{ $thread->channel->name }}
        </a>
    </div>
    <div class="tt-col-value hide-mobile">{{ $thread->replies_favorites_count }}</div>
    <div class="tt-col-value tt-color-select hide-mobile">{{ $thread->replies_count }}</div>
    <div class="tt-col-value hide-mobile">{{ $thread->visits()->count() }}</div>
    <div class="tt-col-value hide-mobile">{{ \Carbon\Carbon::parse($thread->updated_at)->diffForHumans(null, true, true)}}</div>
</div>
