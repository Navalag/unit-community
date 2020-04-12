@if(session()->get('flash_success'))
    <div class="container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            @if(is_array(session()->get('flash_success')))
                {!! implode('', session()->get('flash_success')->all(':message<br/>')) !!}
            @else
                {!! session()->get('flash_success') !!}
            @endif
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
