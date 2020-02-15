@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="tt-single-topic-list" v-cloak>
            <div class="tt-item mt-0">
                @include('threads.partials.question')
            </div>

            <replies @removed="repliesCount--" @added="repliesCount++"></replies>
        </div>
    </thread-view>
@endsection
