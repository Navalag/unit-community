{{-- old --}}
{{--<div class="tt-item">
    <div class="card-header">
        <div class="level">
            <span class="flex">
                {{ $heading }}
            </span>
        </div>
    </div>

    <div class="card-body">
        {!! $body !!}
    </div>
</div>
--}}
<div class="tt-item">
    <div class="tt-col-avatar">
        {{ $heading }}
    </div>
    <div class="tt-col-description">
            {!! $body !!}
    </div>

    {{ $meta}}


</div>
