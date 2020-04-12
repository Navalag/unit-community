@extends('layouts.app')

@section('body')
    @include('layouts.partials.header')

    <main id="tt-pageContent" class="@yield('mainClass')">
        @include('layouts.partials.messages')

        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @stack('modal')
@endsection
