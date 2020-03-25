@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="tt-loginpages-wrapper">
            <div class="tt-loginpages">
                <a href="{{ url('/') }}" class="tt-block-title">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo img">
                    <div class="tt-title">
                        @lang('auth.welcome')
                    </div>
                    <div class="tt-description">
                        @lang('auth.log_into')
                    </div>
                </a>
                <form class="form-default" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">@lang('auth.email')</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"  value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('auth.password')</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        <span class="tt-text">@lang('auth.remember')</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="col ml-auto text-right">
                                <a href="{{ route('password.request') }}" class="tt-underline">@lang('auth.forgot_password')</a>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary btn-block">@lang('auth.login')</button>
                    </div>

                    <p>@lang('auth.dont_have_an_account') <a href="{{ route('register') }}" class="tt-underline">@lang('auth.signup_here')</a></p>
                    <div class="tt-notes">
                        @lang('auth.agree_terms')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
