@extends('layouts.main')

@section('mainClass', 'tt-offset-small')

@section('content')
    <div class="container">
        <div class="tt-tab-wrapper">
            <div class="tt-wrapper-inner">
                <ul class="nav nav-tabs pt-tabs-default" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link show active" data-toggle="tab" href="#about" role="tab"><span>About</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#code-of-conduct" role="tab"><span>Code of Conduct</span></a>
                    </li>
                    <li class="nav-item tt-hide-xs">
                        <a class="nav-link" data-toggle="tab" href="#terms-of-service" role="tab"><span>Terms of Service</span></a>
                    </li>
                    <li class="nav-item tt-hide-md">
                        <a class="nav-link" data-toggle="tab" href="#privacy" role="tab"><span>Privacy</span></a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane show fade active" id="about" role="tabpanel">
                    @include('static.partials.about')
                </div>
                <div class="tab-pane" id="code-of-conduct" role="tabpanel">
                    @include('static.partials.rules')
                </div>
                <div class="tab-pane" id="terms-of-service" role="tabpanel">
                    @include('static.partials.terms')
                </div>
                <div class="tab-pane" id="privacy" role="tabpanel">
                    @include('static.partials.privacy')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            const url = document.location.toString();

            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            }
        });
    </script>
@endpush
