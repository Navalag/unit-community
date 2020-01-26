<div class="tt-item @if($thread->is_trending) tt-itemselect @endif">
    <div class="tt-col-avatar">
        <img class="tt-icon" src="{{ asset('images/svg-sprite/icon-ava-' . strtolower(substr($thread->creator->name, 0, 1)) . '.svg') }}" alt="">
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
                    <li class="show-mobile"><a href="#"><span class="tt-color{{ $thread->channel->id }} tt-badge">{{ $thread->channel->name }}</span></a></li>
                </ul>
            </div>
            <div class="col-1 ml-auto show-mobile">
                <div class="tt-value">1d</div>
            </div>
        </div>
    </div>
    <div class="tt-col-category"><span class="tt-color{{ $thread->channel->id }} tt-badge">{{ $thread->channel->name }}</span></div>
    <div class="tt-col-value hide-mobile">-</div>
    <div class="tt-col-value tt-color-select hide-mobile">{{ $thread->replies_count }}</div>
    <div class="tt-col-value hide-mobile">{{ $thread->visits()->count() }}</div>
    <div class="tt-col-value hide-mobile">-</div>
</div>
