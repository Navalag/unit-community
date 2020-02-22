@extends('layouts.main')

@section('mainClass', 'tt-offset-small')

@section('content')
    <div class="container">
        <div class="tt-topic-list">
            <div class="tt-list-header">
                <div class="tt-col-topic">Topic</div>
                <div class="tt-col-category">Category</div>
                <div class="tt-col-value hide-mobile">Likes</div>
                <div class="tt-col-value hide-mobile">Replies</div>
                <div class="tt-col-value hide-mobile">Views</div>
                <div class="tt-col-value">Activity</div>
            </div>
            @foreach($threads->where('is_trending', true) as $thread)
                @include('threads.partials.list')
            @endforeach
            @forelse($threads->where('is_trending', false) as $thread)
                @include('threads.partials.list')
            @empty
                <p>There are no relevant results at this time.</p>
            @endforelse

            <div class="tt-row py-4">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
