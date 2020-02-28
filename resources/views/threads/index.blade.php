@extends('layouts.main')

@section('mainClass', 'tt-offset-small')

@section('content')
    <div class="container">
        <div class="tt-topic-list">
            <div class="tt-list-header">
                <div class="tt-col-topic">@lang('threads.topic')</div>
                <div class="tt-col-category">@lang('threads.category')</div>
                <div class="tt-col-value hide-mobile">@lang('threads.likes')</div>
                <div class="tt-col-value hide-mobile">@lang('threads.replies')</div>
                <div class="tt-col-value hide-mobile">@lang('threads.views')</div>
                <div class="tt-col-value">@lang('threads.activity')</div>
            </div>
            @foreach($threads->where('is_trending', true) as $thread)
                @include('threads.partials.list')
            @endforeach
            @forelse($threads->where('is_trending', false) as $thread)
                @include('threads.partials.list')
            @empty
                <p>@lang('threads.empty_threads_list')</p>
            @endforelse

            <div class="tt-row py-4">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
