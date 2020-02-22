<footer class="tt-footer">
    <div class="container">
        <hr>
        <div class="tt-footer-line1 row">
            <div class="col-md-3 col-6 order-1 order-md-1">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <h6>UNIT Community</h6>
            </div>
            <div class="col-md-6 text-center order-3 order-md-1 pt-1">
                <a href="/about">About</a>
                <a href="/about#code-of-conduct">Rules</a>
                <a href="/about#terms-of-service">Terms</a>
                <a href="/about#privacy">Privacy</a>
            </div>
            <div class="col-md-3 col-6 order-2 order-md-1">
                <div class="btn-group dropup">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        English
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">English</a>
                        <a class="dropdown-item" href="#">Ukrainian</a>
                        <a class="dropdown-item" href="#">Russian</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tt-footer-line2 row">
            <div class="offset-md-4 col-md-4 text-center">
                <small>&copy; {{ now()->format('Y') }} All rights reserved</small>
            </div>
        </div>
    </div>
</footer>
