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
                        @lang('auth.join_the_forum')
                    </div>
                </a>
                <form class="form-default" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">@lang('auth.username')</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('auth.email')</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('auth.password')</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">@lang('auth.confirm_password')</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password-confirm" required autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <button type="submit"  class="btn btn-secondary btn-block">@lang('auth.create_my_account')</button>
                    </div>

                    <p>@lang('auth.already_have') <a href="{{ route('login') }}" class="tt-underline">@lang('auth.login_here')</a></p>
                    <div class="tt-notes">
                        @lang('auth.agree_terms')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
