@extends('layouts.main')

@section ('head')
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="tt-wrapper-inner">
            <h1 class="tt-title-border">
                Create a New Thread
            </h1>
            <form method="post" action="/threads" class="form-default form-create-topic">
                @csrf

                <div class="form-group">
                    <label for="title">Thread Title</label>
                    <div class="tt-value-wrapper">
                        <input type="text" name="title" class="form-control" id="title" placeholder="Subject of your topic" value="{{ old('title') }}" required>
                        <span class="tt-value-input">99</span>
                    </div>
                    <div class="tt-note">Describe your topic well, while keeping the subject as short as possible.</div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="channel_id">Choose a Channel</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--                        <div class="col-md-8">--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label for="inputTopicTags">Tags</label>--}}
                        {{--                                <input type="text" name="name" class="form-control" id="inputTopicTags" placeholder="Use comma to separate tags">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                <div class="form-group">
                    <wysiwyg name="body" :title="'Thread Body'" :class-names="'pt-2 mb-3'"></wysiwyg>
                    <div class="row">
                        <div class="col-auto">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.public') }}"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-secondary btn-width-lg">Publish</button>
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
