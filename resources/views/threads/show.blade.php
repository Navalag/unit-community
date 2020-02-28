@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
    <thread-view :thread="{{ $thread }}" :translations="{{ json_encode(['thread_updated' => trans('common.thread_updated')]) }}" inline-template>
        <div class="container">
            <div class="tt-single-topic-list" v-cloak>
                <div class="tt-item mt-0">
                    @include('threads.partials.question')
                </div>

                <replies :translations="{{
                     json_encode([
                        'flash_updated' => trans('common.flash_updated'),
                        'best_reply' => trans('common.best_reply'),
                        'delete_text' => trans('common.delete'),
                        'edit_text' => trans('common.edit'),
                        'update_text' => trans('common.update'),
                        'cancel_text' => trans('common.cancel'),
                        'thread_was_locked' => trans('threads.thread_was_locked'),
                        'prev' => trans('pagination.previous'),
                        'next' => trans('pagination.next'),
                        'publish_reply' => trans('common.publish_reply'),
                        'have_something_to_say' => trans('threads.have_something_to_say'),
                        'login_to_participate' => trans('threads.login_to_participate'),
                        'flash_reply_posted' => trans('threads.flash_reply_posted'),
                    ])
                 }}" @removed="repliesCount--" @added="repliesCount++"></replies>
            </div>
        </div>
    </thread-view>
@endsection
