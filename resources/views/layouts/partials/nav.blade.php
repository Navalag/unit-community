<div class="tt-desktop-menu">
    <nav>
        <ul>
            <li>
                <a href="/threads"><span>Browse</span></a>
                <ul>
                    <li><a href="/threads">All Threads</a></li>
                    @if (auth()->check())
                        <li><a href="/threads?by={{ auth()->user()->name }}">My Threads</a></li>
                    @endif
                    <li><a href="/threads?popular=1">Popular All Time</a></li>
                    <li><a href="/threads?unanswered=1">Unanswered Threads</a></li>
                </ul>
            </li>
            <li><a href="/threads/create"><span>New Thread</span></a></li>
            <li>
                <a href="#"><span>Channels</span></a>
                <ul>
                    @foreach ($channels as $channel)
                        <li><a href="/threads/{{ $channel->slug }}">{{ $channel->name }}</a></li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </nav>
</div>

<!-- tt-mobile menu -->
{{--<nav class="panel-menu" id="mobile-menu">--}}
{{--    <ul>--}}

{{--    </ul>--}}
{{--    <div class="mm-navbtn-names">--}}
{{--        <div class="mm-closebtn">--}}
{{--            Close--}}
{{--            <div class="tt-icon">--}}
{{--                <svg>--}}
{{--                    <use xlink:href="#icon-cancel"></use>--}}
{{--                </svg>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="mm-backbtn">Back</div>--}}
{{--    </div>--}}
{{--</nav>--}}
