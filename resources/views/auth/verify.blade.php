@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="tt-loginpages-wrapper">
            <div class="tt-loginpages">
                <a href="{{ url('/') }}" class="tt-block-title">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo img">
                    <div class="tt-title">
                        @lang('auth.verify')
                    </div>
                </a>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        @lang('auth.fresh_verification')
                    </div>
                @endif

                <form class="form-default">
                    @csrf

                    <p>@lang('auth.before_proceeding')</p>
                    <p>@lang('auth.did_not_receive') <a href="{{ route('verification.resend') }}" class="tt-underline">@lang('auth.request_another')</a>.</p>
                </form>
            </div>
        </div>
    </div>
@endsection
