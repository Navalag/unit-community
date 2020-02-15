@extends('layouts.app')

@section('body')
    @include('layouts.partials.header')

    <main id="tt-pageContent" class="@yield('mainClass')">
        <div class="container">
            @yield('content')

            @include('layouts.partials.footer')
        </div>
    </main>
@endsection
