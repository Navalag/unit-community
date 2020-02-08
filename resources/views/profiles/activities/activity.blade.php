<div class="tt-item user-activity">
    <div class="tt-col-avatar">
        {{ $avatar }}
    </div>
    <div class="tt-col-description">
        {!! $body !!}
        <div class="row align-items-center no-gutters hide-desktope">
            <div class="col-9">
                <ul class="tt-list-badge">
                    <li class="show-mobile">
                        {{ $channel }}
                    </li>
                </ul>
                <a href="#" class="tt-btn-icon show-mobile">
                    {{ $statusIcon }}
                </a>
            </div>
            <div class="col-3 ml-auto show-mobile">
                <div class="tt-value">
                    {{ $date }}
                </div>
            </div>
        </div>
    </div>
    <div class="tt-col-category tt-col-value-large hide-mobile">
        {{ $channel }}
    </div>
    <div class="tt-col-value-large hide-mobile">
        <a href="#" class="tt-btn-icon">
            {{ $statusIcon }}
        </a>
    </div>
    <div class="tt-col-value-large hide-mobile">
        {{ $date }}
    </div>
</div>
