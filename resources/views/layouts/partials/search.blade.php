<div class="tt-search">
    <!-- toggle -->
{{--    <button class="tt-search-toggle" data-toggle="modal" data-target="#modalAdvancedSearch">--}}
{{--        <img class="tt-icon" src="{{ asset('images/svg-sprite/icon-search.svg') }}">--}}
{{--    </button>--}}
    <!-- /toggle -->
    <ais-index
        class="search-wrapper"
        app-id="{{ config('scout.algolia.id') }}"
        api-key="{{ config('scout.algolia.public') }}"
        index-name="threads"
    >
        <ais-search-box class="search-form" v-cloak>
            <ais-input placeholder="Search" :autofocus="false" :spellcheck="true" class="tt-search__input"></ais-input>
            <button class="tt-search__btn" type="button">
                <img class="tt-icon" src="{{ asset('images/svg-sprite/icon-search.svg') }}">
            </button>
        </ais-search-box>
        <div class="search-results">
            <div class="tt-search-scroll">
                <ul>
                    <ais-results :results-per-page="@json(7)">
                        <template slot-scope="{ result }">
                            <li>
                                <a :href="result.path">
                                    <h6 class="tt-title">
                                        <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                    </h6>
                                    <div class="tt-description">
                                        <ais-highlight :result="result" attribute-name="body"></ais-highlight>
                                    </div>
                                </a>
                            </li>
                        </template>
                    </ais-results>
                </ul>
            </div>
            <button type="button" class="tt-view-all" id="closeSearchPopUp">Close</button>
        </div>
    </ais-index>
</div>
