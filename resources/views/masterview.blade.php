<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Feature-Policy" content="otp-credentials 'self'">
    <title>NeoWear</title>
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.5.1-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('library/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    @yield('styles')
</head>

<body>
    <header class="nav-bar">
        <nav>
            <ul class="menu-list">
                <li class="menu menu-item">
                    <div class="menu_close">Close</div>
                    <div class="menu_open">Menu</div>
                </li>
                <li class="website_link menu-item"><a href="{{ url('/index') }}">NeoWear</a></li>
                <li class="member menu-item">
                    <form action="{{ route('guest.search') }}" method="get" class="search-form">
                        <input type="text" placeholder="Search.." id="search-product" name="productName" value="{{ request('productName') }}">
                        <div class="search-list-box">
                            <ul class="search-list"></ul>
                        </div>
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    @if(session('user_id') && session('user_type') == 'Normal')
                        <a href="{{ url('/logout') }}" class="member_open">Log Out</a>
                    @else
                        <a href="{{ url('/signup') }}" class="member_open">Join Us</a>
                    @endif
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="menu-container">
            <div class="menu-box">
                <ul>
                    <li>
                        <form action="{{ route('guest.search') }}" method="get" class="small-search-form">
                            <input type="text" placeholder="Search.." id="search-product" name="productName" value="{{ request('productName') }}">
                            <div class="search-list-box">
                                <ul class="search-list"></ul>
                            </div>
                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </li>
                    <li><a href="{{ url('/index') }}"><span><i class="fa-solid fa-house"></i></span>Home</a></li>
                    <li><a href="{{ url('/search') }}"><span><i class="fa-solid fa-shop"></i></span>Shop</a></li>
                    @if(session('user_id') && session('user_type') == 'Normal')
                        <li><a href="{{ url('/profile') }}"><span><i class="fa-solid fa-user"></i></span>Profile</a></li>
                        <li><a href="{{ url('/wishlist') }}"><span><i class="fa-solid fa-heart"></i></span>Wishlist</a></li>
                        <li><a href="{{ url('/cart') }}"><span><i class="fa-solid fa-cart-shopping"></i></span>Cart</a></li>
                    @endif
                    <li><a href="{{ url('/contact') }}"><span><i class="fa-solid fa-headset"></i></span>Contact</a></li>
                </ul>
            </div>
        </div>
        @include('alert')
        <main id="main">
            @yield('main')
        </main>
    </div>
    <footer>
        <div class="footer-main">
            <div class="footer-box-1">
                <div class="footer-contact-us">
                    <span>Connect with us</span>
                    <ul>
                        @php
                            use App\Models\about_link;
                            $about_link = about_link::all();
                        @endphp

                        @if(count($about_link) > 0)
                            @foreach ($about_link as $link) 
                                <li><a href="{{ $link->link_url }}" target="_blank">{{ $link->link_name }}</a></li>
                            @endforeach
                        @else
                            <li class="no-link">No links available.</li>
                        @endif
                    </ul>
                </div>
                <div class="footer-logo">
                    <a href="{{ url('/index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M415.4 512h-95.1L212.1 357.5v91.1L125.7 512H28V29.8L68.5 0h108.1l123.7 176.1V63.5L386.7 0h97.7v461.5zM38.8 35.3V496l72-52.9V194l215.5 307.6h84.8l52.4-38.2h-78.3L69 13zm82.5 466.6l80-58.8v-101l-79.8-114.4v220.9L49 501.9h72.3zM80.6 10.8l310.6 442.6h82.4V10.8h-79.8v317.6L170.9 10.8zM311 191.7l72 102.8V15.9l-72 53v122.7z" />
                        </svg>
                        <div class="logo-name">
                            <p>neowear</p>
                        </div>
                    </a>
                </div>
                <div class="footer-quick-link">
                    <span>Quick Links</span>
                    <ul>
                        <li><a href="{{ url('/index') }}">Home</a></li>
                        <li><a href="{{ url('/search') }}">Shop</a></li>
                        @if (session('user_id') && session('user_type') == 'Normal')
                            <li><a href="{{ url('/profile') }}">Profile</a></li>
                        @endif
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-box-2">
                <p>NeoWear © 2025 All Copy Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script src="{{asset('library/gsap.min.js')}}"></script>
    <script src="{{ asset('library/ScrollTrigger.min.js') }}"></script>
    <script src="{{asset('library/lenis.min.js')}}"></script>
    <script src="{{ asset('library/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/master.js') }}"></script>
    @yield('scripts')
</body>

</html>