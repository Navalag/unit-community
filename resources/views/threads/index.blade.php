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
            @forelse($threads as $thread)
                @include('threads.partials.list')

                @if(auth()->guest() && $loop->last)
                    @include('partials.auth_block')
                @endif
            @empty
                @include('partials.empty_result_line', ['message' => trans('threads.empty_threads_list')])
            @endforelse

            <div class="tt-row py-4">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
