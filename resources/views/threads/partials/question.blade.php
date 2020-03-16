{{-- Editing the question. --}}
<div class="tt-single-topic" v-if="editing">
    <div class="tt-item-header">
        <div class="tt-item-info info-top">
            <div class="tt-avatar-icon">
                <a href="{{ LaravelLocalization::localizeUrl('/profiles/' . $thread->creator->name) }}">
                    <i class="tt-icon"><img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}"></i>
                </a>
            </div>
            <div class="tt-avatar-title">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
            </div>
            <a href="#" class="tt-info-time">
                <i class="tt-icon"><svg><use xlink:href="#icon-time"></use></svg></i>{{ $thread->created_at->diffForHumans() }}
            </a>
        </div>
        <div class="form-default form-group mb-0 mt-3">
            <input type="text" class="form-control" v-model="form.title">
        </div>
    </div>
    <div class="tt-item-description pt-3">
        <wysiwyg v-model="form.body" :class-names="'pt-2'"></wysiwyg>
    </div>
    <div class="tt-item-info info-bottom">
        <ul class="tt-list-badge tt-size-lg">
            <li>
                <button class="btn btn-secondary btn-sm" @click="update">@lang('common.update')</button>
            </li>
            <li>
                <button class="btn btn-primary btn-sm" @click="resetForm">@lang('common.cancel')</button>
            </li>
            @can ('update', $thread)
                <li>
                    <form action="{{ $thread->path() }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-link btn-sm">@lang('common.delete_thread')</button>
                    </form>
                </li>
            @endcan

        </ul>
        <div class="col-separator"></div>
        <a href="#" class="tt-icon-btn tt-hover-02 tt-small-indent">
            <i class="tt-icon"><svg><use xlink:href="#icon-reply"></use></svg></i>
            <span class="tt-text" v-text="repliesCount"></span>
        </a>
        <a href="#" class="tt-icon-btn tt-hover-02 tt-small-indent">
            <i class="tt-icon"><svg><use xlink:href="#icon-view"></use></svg></i>
            <span class="tt-text">{{ $thread->visits()->count() }}</span>
        </a>
    </div>
</div>

{{-- Viewing the question. --}}
<div class="tt-single-topic" v-else>
    <div class="tt-item-header">
        <div class="tt-item-info info-top">
            <div class="tt-avatar-icon">
                <a href="{{ LaravelLocalization::localizeUrl('/profiles/' . $thread->creator->name) }}">
                    <i class="tt-icon"><img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}"></i>
                </a>
            </div>
            <div class="tt-avatar-title">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
            </div>
            <a href="#" class="tt-info-time">
                <i class="tt-icon"><svg><use xlink:href="#icon-time"></use></svg></i>{{ $thread->created_at->diffForHumans() }}
            </a>
        </div>
        <h3 class="tt-item-title">
            <a href="#" v-text="title"></a>
        </h3>
    </div>
    <div class="tt-item-description">
        <p v-html="body"></p>
    </div>
    <div class="tt-item-info info-bottom">
        <ul class="tt-list-badge tt-size-lg">
            <li v-if="authorize('isAdmin')">
                <button class="btn btn-secondary btn-color01 btn-sm"
                        @click="toggleLock"
                        v-text="locked ? '{{ trans('common.unlock') }}' : '{{ trans('common.lock') }}'"></button>
            </li>
            <li v-if="signedIn">
                <subscribe-button
                    :active="{{ json_encode($thread->isSubscribedTo) }}"
                    :translations="{{ json_encode([
                        'unsubscribe_text' => trans('common.unsubscribe'),
                        'subscribe_text' => trans('common.subscribe'),
                    ]) }}"></subscribe-button>
            </li>
            <li v-if="authorize('owns', thread)">
                <button class="btn btn-primary btn-sm" @click="editing = true">@lang('common.edit')</button>
            </li>
        </ul>
        <div class="col-separator"></div>
        <a href="#" class="tt-icon-btn tt-hover-02 tt-small-indent">
            <i class="tt-icon"><svg><use xlink:href="#icon-reply"></use></svg></i>
            <span class="tt-text" v-text="repliesCount"></span>
        </a>
        <a href="#" class="tt-icon-btn tt-hover-02 tt-small-indent">
            <i class="tt-icon"><svg><use xlink:href="#icon-view"></use></svg></i>
            <span class="tt-text">{{ $thread->visits()->count() }}</span>
        </a>
    </div>
</div>
