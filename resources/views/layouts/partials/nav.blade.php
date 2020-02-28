<div class="tt-desktop-menu">
    <nav>
        <ul>
            <li>
                <a href="{{ LaravelLocalization::localizeUrl('/threads') }}"><span>@lang('header.browse')</span></a>
                <ul>
                    <li><a href="{{ LaravelLocalization::localizeUrl('/threads') }}">@lang('header.all_threads')</a></li>
                    @if (auth()->check())
                        <li><a href="{{ LaravelLocalization::localizeUrl('/threads?by=' . auth()->user()->name) }}">@lang('header.my_threads')</a></li>
                    @endif
                    <li><a href="{{ LaravelLocalization::localizeUrl('/threads?popular=1') }}">@lang('header.popular_all_time')</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl('/threads?unanswered=1') }}">@lang('header.unanswered_threads')</a></li>
                </ul>
            </li>
            <li><a href="{{ LaravelLocalization::localizeUrl('/threads/create') }}"><span>@lang('header.new_thread')</span></a></li>
            <li>
                <a href="#"><span>@lang('header.channels')</span></a>
                <ul>
                    @foreach ($channels as $channel)
                        <li><a href="{{ LaravelLocalization::localizeUrl('/threads/' . $channel->slug) }}">{{ $channel->name }}</a></li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </nav>
</div>
