@extends('layouts.app')

@section('body')
    @include('layouts.partials.header')

    <main id="tt-pageContent" class="@yield('mainClass')">
        @yield('content')

        <div class="container">
            @include('layouts.partials.footer')
        </div>
    </main>
@endsection
