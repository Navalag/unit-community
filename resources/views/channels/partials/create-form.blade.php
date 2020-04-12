<div class="modal fade" id="createChannel" tabindex="-1" role="dialog" aria-label="Channel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="tt-modal-advancedSearch">
                <div class="tt-modal-title mb-2 pb-3">
                    @lang('channel.channels')
                    <a href="#" class="pt-close-modal" data-dismiss="modal" aria-label="Close">
                        <svg class="icon">
                            <use xlink:href="#close"></use>
                        </svg>
                    </a>
                </div>
                <form class="form-default" method="post" action="{{ LaravelLocalization::localizeUrl('/channels') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">@lang('channel.name')</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ?? '' }}" placeholder="{{ trans('channel.name_placeholder') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">@lang('channel.description')</label>
                        <textarea name="description" class="form-control p-3" cols="3" id="description" placeholder="{{ trans('channel.description_placeholder') }}" required>{{ old('description') ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary">@lang('common.create')</button>

                    @if (count($errors))
                        <ul class="alert alert-danger mt-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
