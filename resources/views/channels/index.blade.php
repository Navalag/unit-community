@extends('layouts.main')

@section('content')
    <div class="tt-custom-mobile-indent container">
        <div class="tt-categories-title">
            <div class="tt-title">@lang('channel.channels')</div>
            @if (auth()->check() && auth()->user()->is_admin)
                <button type="button" class="btn btn-primary btn-sm ml-3" data-toggle="modal" data-target="#createChannel">@lang('common.create')</button>
            @endif
        </div>
        <div class="tt-categories-list">
            <div class="row">
                @foreach($channels as $channel)
                    <channel-card :channel-initial="{{ json_encode($channel) }}"
                        :translate="{{ json_encode([
                            'name' => trans('channel.name'),
                            'description' => trans('channel.description'),
                            'cancel' => trans('common.cancel'),
                            'dialog_confirm' => trans('common.dialog_confirm'),
                            'delete' => trans('common.delete'),
                            'update' => trans('common.update'),
                            'threads' => trans('common.threads'),
                            'edit' => trans('common.edit'),
                        ]) }}"></channel-card>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@if (auth()->check() && auth()->user()->is_admin)
    @push('modal')
        @include('channels.partials.create-form')
    @endpush
@endif
