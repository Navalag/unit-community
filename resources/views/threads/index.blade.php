@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include ('threads._list')

            <div class="col-md-8 offset-md-5">
                {{ $threads->render() }}
            </div>
        </div>
    </div>
@endsection
