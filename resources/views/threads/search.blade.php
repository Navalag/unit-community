@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ais-index
                        app-id="{{ config('scout.algolia.id') }}"
                        api-key="{{ config('scout.algolia.public') }}"
                        index-name="threads"
                        query="{{ request('q') }}"
                >
                    <div class="row">
                        <div class="col-md-8">
                            <ais-results>
                                <template slot-scope="{ result }">
                                    <li>
                                        <a :href="result.path">
                                            <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                        </a>
                                    </li>
                                </template>
                            </ais-results>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header">
                                    Search
                                </div>

                                <div class="card-body">
                                    <ais-index
                                            app-id="{{ config('scout.algolia.id') }}"
                                            api-key="{{ config('scout.algolia.public') }}"
                                            index-name="threads"
                                    >
                                        <ais-search-box>
                                            <ais-input placeholder="Find a thread..." :autofocus="true" class="form-control"></ais-input>
                                        </ais-search-box>
                                    </ais-index>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    Filter By Channel
                                </div>

                                <div class="card-body">
                                    <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
                                </div>
                            </div>

                            @if (count($trending))
                                <div class="card mb-3">
                                    <div class="card-header">
                                        Trending Threads
                                    </div>

                                    <div class="card-body">
                                        <ul class="list-group">
                                            @foreach ($trending as $thread)
                                                <li class="list-group-item">
                                                    <a href="{{ url($thread->path) }}">
                                                        {{ $thread->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </ais-index>
            </div>
        </div>
    </div>
@endsection