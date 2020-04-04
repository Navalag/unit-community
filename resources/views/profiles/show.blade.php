@extends('layouts.main')

@section('mainClass', 'tt-offset-small')

@section('content')
    <div class="tt-wrapper-section">
        <div class="container">
            <div class="tt-user-header">
                <div class="tt-col-avatar">
                        <img class="tt-icon" src="{{ $profileUser->avatar_path }}" alt="{{ $profileUser->name }}">
                </div>
                <div class="tt-col-title">
                    <div class="tt-title">
                        <a href="#">{{ $profileUser->name }}</a>
                    </div>
                    <ul class="tt-list-badge">
                        <li><a href="#"><span class="tt-color14 tt-badge">LVL : {{ $profileUser->reputation }}</span></a></li>
                    </ul>
                    <a href="#" class="tt-btn-icon" id="js-settings-btn">
                        <svg class="tt-icon">
                            <use xlink:href="#icon-settings_fill"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="tt-tab-wrapper">
            <div class="tt-topic-list">
                <div class="tt-list-header user-activity">
                    <div class="tt-col-topic">@lang('profiles.topic')</div>
                    <div class="tt-col-value-large hide-mobile">@lang('profiles.category')</div>
                    <div class="tt-col-value-large hide-mobile">@lang('profiles.type')</div>
                    <div class="tt-col-value-large hide-mobile">@lang('profiles.activity')</div>
                </div>
                @forelse ($activities as $activity)
                    @if(view()->exists("profiles.activities.{$activity->type}"))
                        @include ("profiles.activities.{$activity->type}")
                    @endif
                @empty
                    @include('partials.empty_result_line', ['message' => trans('profiles.activity_empty_set')])
                @endforelse
                <div class="tt-row py-4">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
    @if(auth()->check())
        <div class="dispayingTextDiv"></div>
        <div id="js-popup-settings" class="tt-popup-settings">
            <div class="tt-btn-col-close">
                <a href="#">
                    <span class="tt-icon-text">
                        @lang('auth.user_settings.settings')
                    </span>
                    <span class="tt-icon-close">
                        <svg>
                            <use xlink:href="#icon-cancel"></use>
                        </svg>
                    </span>
                </a>
            </div>

            <user-settings :userdata="{{ $profileUser }}" :translations="{{
                json_encode([
                    'username' => trans('auth.user_settings.username'),
                    'email' => trans('auth.user_settings.email'),
                    'old_password' => trans('auth.user_settings.old_password'),
                    'new_password' => trans('auth.user_settings.new_password'),
                    'confirm_new_password' => trans('auth.user_settings.confirm_new_password'),
                    'upload_picture' => trans('auth.user_settings.upload_picture'),
                    'redirect_msg' => trans('auth.user_settings.redirect_to_profile'),
                    'email_not_verified' => trans('auth.user_settings.email_not_verified'),
                    'update' => trans('common.update'),
                    'checkbox_thread_was_updated' => trans('auth.user_settings.checkbox_thread_was_updated'),
                    'checkbox_likes_reply' => trans('auth.user_settings.checkbox_likes_reply'),
                    'checkbox_mentions_me' => trans('auth.user_settings.checkbox_mentions_me'),
                ])
            }}"></user-settings>
        </div>
    @endif
@endsection
