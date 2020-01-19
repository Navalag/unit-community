@extends('layouts.app')

@section('body')
    @include('layouts.nav')

    <main class="py-4">
        @yield('content')
    </main>
@endsection
