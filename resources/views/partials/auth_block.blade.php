<div class="tt-item tt-item-popup">
    <div class="tt-col-avatar"></div>
    <div class="tt-col-message">
        @lang('auth.auth_block_include')
    </div>
    <div class="tt-col-btn">
        <a href="{{ LaravelLocalization::localizeUrl('/login') }}" class="btn btn-primary">@lang('auth.login')</a>
        <a href="{{ LaravelLocalization::localizeUrl('/register') }}" class="btn btn-secondary">@lang('auth.sign_up')</a>
    </div>
</div>
