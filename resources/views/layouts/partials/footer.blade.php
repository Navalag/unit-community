<footer class="tt-footer">
    <div class="container">
        <hr>
        <div class="tt-footer-line1 row">
            <div class="col-md-3 col-7 order-1 order-md-1">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <h6>@lang('common.app_name')</h6>
            </div>
            <div class="col-md-6 text-center order-3 order-md-1 pt-3 pt-md-0">
                <a href="{{ LaravelLocalization::localizeUrl('/about') }}">@lang('footer.about')</a>
                <a href="{{ LaravelLocalization::localizeUrl('/about#code-of-conduct') }}">@lang('footer.rules')</a>
                <a href="{{ LaravelLocalization::localizeUrl('/about#terms-of-service') }}">@lang('footer.terms')</a>
                <a href="{{ LaravelLocalization::localizeUrl('/about#privacy') }}">@lang('footer.privacy')</a>
            </div>
            <div class="col-md-3 col-5 order-2 order-md-1">
                <div class="btn-group dropup">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ LaravelLocalization::getCurrentLocaleNative() }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                            <a class="dropdown-item"
                               rel="alternate"
                               hreflang="{{ $localeCode }}"
                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="tt-footer-line2 row">
            <div class="offset-md-4 col-md-4 text-center">
                <small>&copy; {{ now()->format('Y') }} @lang('footer.legal')</small>
            </div>
        </div>
    </div>
</footer>
