@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($threads as $thread)
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->title }}
                                    </a>
                                </h4>
                                <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="body">{{ $thread->body }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
