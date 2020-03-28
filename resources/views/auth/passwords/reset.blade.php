@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="tt-loginpages-wrapper">
            <div class="tt-loginpages">
                @include('auth.partials.welcome_part', [
                    'title' => trans('auth.reset_password'),
                    'description' => false,
                ])
                <form class="form-default" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email">@lang('auth.email')</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"  value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                        <button type="submit" class="btn btn-secondary btn-block">@lang('auth.reset_password')</button>
                    </div>

                    @include('auth.partials.agree_terms_and_privacy')
                </form>
            </div>
        </div>
    </div>
@endsection
