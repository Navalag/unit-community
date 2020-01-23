@extends('layouts.app')

@section('body')
    @include('layouts.header')

    <main style="padding-top: 100px">
        @yield('content')
    </main>
@endsection
