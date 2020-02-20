@extends('layouts.main')

@section('mainClass', 'tt-offset-small')

@section('content')
    <div class="tt-wrapper-section">
        <div class="container">
            <div class="tt-user-header">
                <div class="tt-col-avatar">
                    <div class="tt-icon">
                        <img class="tt-icon" src="{{ $profileUser->avatar_path }}" alt="{{ $profileUser->name }}">
                    </div>
                </div>
                <div class="tt-col-title">
                    <div class="tt-title">
                        <a href="#">{{ $profileUser->name }}</a>
                    </div>
                    <ul class="tt-list-badge">
                        <li><a href="#"><span class="tt-color14 tt-badge">LVL : 0</span></a></li>
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
                    <div class="tt-col-topic">Topic</div>
                    <div class="tt-col-value-large hide-mobile">Category</div>
                    <div class="tt-col-value-large hide-mobile">Type</div>
                    <div class="tt-col-value-large hide-mobile">Activity</div>
                </div>
                @forelse ($activities as $activity)
                    @if(view()->exists("profiles.activities.{$activity->type}"))
                        @include ("profiles.activities.{$activity->type}")
                    @endif
                @empty
                    <p>There is no activity for this user yet.</p>
                @endforelse
                <div class="tt-row py-4">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
    @if(Auth::check())
        <div class="dispayingTextDiv"></div>
        <div id="js-popup-settings" class="tt-popup-settings">
            <div class="tt-btn-col-close">
                <a href="#">
                <span class="tt-icon-title">
                    <svg>
                        <use xlink:href="#icon-settings_fill"></use>
                    </svg>
                </span>
                    <span class="tt-icon-text">
                    Settings
                </span>
                    <span class="tt-icon-close">
                    <svg>
                        <use xlink:href="#icon-cancel"></use>
                    </svg>
                </span>
                </a>
            </div>

            <user-settings :userdata="{{ $profileUser }}"></user-settings>
        </div>
    @endif
@endsection
