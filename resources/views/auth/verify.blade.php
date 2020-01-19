@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="tt-loginpages-wrapper">
            <div class="tt-loginpages">
                <a href="{{ url('/') }}" class="tt-block-title">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo img">
                    <div class="tt-title">
                        Verify Your Email Address
                    </div>
                </a>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <form class="form-default">
                    @csrf

                    <p>Before proceeding, please check your email for a verification link.</p>
                    <p>If you did not receive the email, <a href="{{ route('verification.resend') }}" class="tt-underline">click here to request another</a>.</p>
                </form>
            </div>
        </div>
    </div>
@endsection
