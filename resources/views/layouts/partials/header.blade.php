@include('layouts.partials.nav_mobile')

<header id="tt-header">
    <div class="container">
        <div class="row tt-row no-gutters">
            <div class="col-auto">
                <!-- toggle mobile menu -->
                <a class="toggle-mobile-menu" href="#">
                    <img class="tt-icon" src="{{ asset('images/svg-sprite/icon-menu_icon.svg') }}" alt="">
                </a>
                <!-- /toggle mobile menu -->
                <!-- logo -->
                <div class="tt-logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt=""></a>
                </div>
                <!-- /logo -->
                <!-- desctop menu -->
                @include('layouts.partials.nav')
                <!-- /desctop menu -->
                <!-- tt-search -->
{{--                @include('layouts.partials.search')--}}
                <!-- /tt-search -->
            </div>
            <div class="col-auto ml-auto">
                <!-- Authentication Links -->
                @guest
                    <div class="tt-account-btn">
                        <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">Sign up</a>
                        @endif
                    </div>
                @else
                    <div class="tt-user-info d-flex justify-content-center">
                        <user-notifications></user-notifications>
                        <a href="#" class="tt-btn-icon">
                            <i class="tt-icon"><img src="{{ asset('images/svg-sprite/icon-notification.svg') }}" alt=""></i>
                        </a>
                        <div class="tt-avatar-icon tt-size-md">
                            <i class="tt-icon"><img src="{{ auth()->user()->avatar_path }}" alt="{{ auth()->user()->name }}"></i>
                        </div>
                        <div class="custom-select-01">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ auth()->user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile', auth()->user()) }}">
                                    My Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
{{--                            <select>--}}
{{--                                <option value="Default Sorting">{{ Auth::user()->name }}</option>--}}
{{--                                <option value="value 01">value 01</option>--}}
{{--                                <option value="value 02">value 02</option>--}}
{{--                            </select>--}}
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>
