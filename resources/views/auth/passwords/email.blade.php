@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="tt-loginpages-wrapper">
            <div class="tt-loginpages">
                <a href="{{ url('/') }}" class="tt-block-title">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo img">
                    <div class="tt-title">
                        @lang('auth.reset_password')
                    </div>
                </a>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="form-default" method="POST" action="{{ route('password.email') }}">
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
                        <button type="submit" class="btn btn-secondary btn-block">@lang('auth.reset_link')</button>
                    </div>

                    <p>@lang('auth.already_have') <a href="{{ route('login') }}" class="tt-underline">@lang('auth.login')</a></p>
                </form>
            </div>
        </div>
    </div>
@endsection
