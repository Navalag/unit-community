@extends('layouts.main')

@section('content')
    <div class="tt-layout-404">
           <span class="tt-icon">
                <svg class="icon">
                  <use xlink:href="#icon-error_404"></use>
                </svg>
           </span>
        <h6 class="tt-title">ERROR 404</h6>
        <p>@lang('404.not_found_message')</p>
    </div>
@endsection
