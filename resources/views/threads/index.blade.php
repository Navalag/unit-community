@extends('layouts.main')

@section('mainClass', 'tt-offset-small')

@section('content')
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
@endsection

{{-- Old design sample, should be removed when all functionality will be implemented --}}

{{--            <div class="col-md-4">--}}
{{--                <div class="card mb-4">--}}
{{--                    <div class="card-header">--}}
{{--                        Search--}}
{{--                    </div>--}}

{{--                    <div class="card-body">--}}
{{--                        <form method="GET" action="/threads/search">--}}
{{--                            <div class="form-group">--}}
{{--                                <input type="text" placeholder="Search for something..." name="q" class="form-control">--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <button class="btn btn-primary" type="submit">Search</button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                @if (count($trending))--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            Trending Threads--}}
{{--                        </div>--}}

{{--                        <div class="card-body">--}}
{{--                            <ul class="list-group">--}}
{{--                                @foreach ($trending as $thread)--}}
{{--                                    <li class="list-group-item">--}}
{{--                                        <a href="{{ url($thread->path) }}">--}}
{{--                                            {{ $thread->title }}--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
