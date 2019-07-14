@forelse ($threads as $thread)
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="level">
                    <h5 class="flex">
                        <a href="{{ $thread->path() }}">
                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <h4>
                                    <strong>
                                        {{ $thread->title }}
                                    </strong>
                                </h4>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>
                    </h5>

                    <a href="{{ $thread->path() }}">
                        {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}
                    </a>
                </div>

                <h6>
                    Posted By: <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                </h6>
            </div>

            <div class="card-body">
                <div class="body">{{ $thread->body }}</div>
            </div>
        </div>
    </div>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse
