@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card border-0">
                <div class="card-header mb-0 pb-0 border-0">
                    <a href="/">
                        <img src="images/logo.png">
                        <p class="mt-4 mb-0 text-dark" style="font-size: 18px; font-weight: 600;">{{ __('Welcome to Forum19') }}</p>
                        <p>{{ __('Join the forum to unlock true power of community.') }}</p>
                        <p class="col-md-6 border-bottom mt-4 mb-4"></p>
                    </a>
                </div>

                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="name" class="col-form-label font-weight-bold">{{ __('Username') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="azyrusmax" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="email" class="col-form-label font-weight-bold">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Sample@sample.com" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password" class="col-form-label font-weight-bold">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="************">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password-confirm" class="col-form-label font-weight-bold">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="************">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-secondary col-md-12">
                                    {{ __('Create my account') }}
                                </button>
                            </div>
                        </div>
                        <p class="mt-4" style="font-size: 16px;">Already have an account? <a href="#">Login here</a></p>
                        <div class="mt-lg-5" style="font-size: 14px;">
                            By signing up, signing in or continuing, I agree to
                            Forum19’s <a href="#">Terms of Use</a> and <a href="#">Privacy Policy.</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
