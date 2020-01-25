@extends('layouts.app')

@section('body')
    @include('layouts.partials.header')

    <main id="tt-pageContent" class="@yield('mainClass')">
        @yield('content')
    </main>
@endsection
