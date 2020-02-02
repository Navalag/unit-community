{{-- Editing the question. --}}
<div class="card mb-3" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text" class="form-control" v-model="form.title">
        </div>
    </div>

    <div class="card-body">
        <div class="form-group">
            <wysiwyg v-model="form.body"></wysiwyg>
        </div>
    </div>

    <div class="card-footer">
        <div class="level">
            <button class="btn btn-primary btn-sm level-item" @click="update">Update</button>
            <button class="btn btn-secondary btn-sm level-item" @click="resetForm">Cancel</button>

            @can ('update', $thread)
                <form action="{{ $thread->path() }}" method="POST" class="ml-a">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
            @endcan

        </div>
    </div>
</div>

{{-- Viewing the question. --}}
<div class="tt-single-topic" v-else>
    <div class="tt-item-header">
        <div class="tt-item-info info-top">
            <div class="tt-avatar-icon">
                <i class="tt-icon"><img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}"></i>
            </div>
            <div class="tt-avatar-title">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
            </div>
            <a href="#" class="tt-info-time">
                <i class="tt-icon"><img src="{{ asset('images/svg-sprite/icon-time.svg') }}" alt=""></i>{{ $thread->created_at->diffForHumans() }}
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
            <li v-if="signedIn">
                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
            </li>
            <li v-if="authorize('owns', thread)">
                <a href="#" @click="editing = true"><span class="tt-badge">Edit</span></a>
            </li>
            <li v-if="authorize('isAdmin')">
                <a href="#" @click="toggleLock">
                    <span class="tt-badge" v-text="locked ? 'Unlock' : 'Lock'"></span>
                </a>
            </li>
        </ul>
        <div class="col-separator"></div>
        <a href="#" class="tt-icon-btn tt-hover-02 tt-small-indent">
            <i class="tt-icon"><img src="{{ asset('images/svg-sprite/icon-reply.svg') }}" alt=""></i>
            <span class="tt-text" v-text="repliesCount"></span>
        </a>
        <a href="#" class="tt-icon-btn tt-hover-02 tt-small-indent">
            <i class="tt-icon"><img src="{{ asset('images/svg-sprite/icon-view.svg') }}" alt=""></i>
            <span class="tt-text">{{ $thread->visits()->count() }}</span>
        </a>
    </div>
</div>
