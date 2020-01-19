@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="tt-loginpages-wrapper">
            <div class="tt-loginpages">
                <a href="{{ url('/') }}" class="tt-block-title">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo img">
                    <div class="tt-title">
                        Welcome to Forum19
                    </div>
                    <div class="tt-description">
                        Log into your account to unlock true power of community.
                    </div>
                </a>
                <form class="form-default" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"  value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
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
                                        <span class="tt-text">Remember me</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="col ml-auto text-right">
                                <a href="{{ route('password.request') }}" class="tt-underline">Forgot Password</a>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary btn-block">Log in</button>
                    </div>

                    <p>Don’t have an account? <a href="{{ route('register') }}" class="tt-underline">Signup here</a></p>
                    <div class="tt-notes">
                        By Logging in, signing in or continuing, I agree to
                        Forum19’s <a href="#" class="tt-underline">Terms of Use</a> and <a href="#" class="tt-underline">Privacy Policy.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
