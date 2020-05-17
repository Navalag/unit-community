@extends('layouts.main')

@section ('head')
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="tt-wrapper-inner">
            <h1 class="tt-title-border">
                @lang('threads.create.title')
            </h1>
            <form method="post" action="{{ LaravelLocalization::localizeUrl('/threads') }}" class="form-default form-create-topic">
                @csrf

                <div class="form-group">
                    <label for="title">@lang('threads.create.title2')</label>
                    <thread-tittle-input
                        :translation="{{ json_encode(trans('threads.create.title_placeholder')) }}"
                        :value="{{ json_encode(old('title')) }}"
                        :max-length="150">
                    </thread-tittle-input>
                    <div class="tt-note">@lang('threads.create.title_helper_text')</div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="channel_id">@lang('threads.create.channel_label')</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">@lang('threads.create.channel_choose_one')</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="inputTags">@lang('threads.create.tags')</label>
                                <input type="text" name="tags" class="form-control" id="inputTags" placeholder="{{ trans('threads.create.comma_separate_tags') }}">
                                <div class="tt-note">@lang('threads.create.tags_limit')</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <wysiwyg :name="'body'"
                             :title="'{{ trans('threads.create.body_title') }}'"
                             :class-names="'pt-2 mb-3'"
                             :placeholder="'{{ trans('threads.create.body_placeholder') }}'"></wysiwyg>
                    <div class="row">
                        <div class="col-auto">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.public') }}"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-secondary btn-width-lg">@lang('threads.create.publish')</button>
                        </div>
                    </div>
                </div>

                @if (count($errors))
                    <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>
        </div>
    </div>
@endsection
