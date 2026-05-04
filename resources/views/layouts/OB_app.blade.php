<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Event Planner</title>
    <link rel="stylesheet" href="{{ asset('css/OB_style.css') }}">
</head>

<body class="app-layout">

{{-- ================= NAVBAR ================= --}}
@if(!in_array(Route::currentRouteName(), ['login', 'register']))
<header class="navbar">
    <div class="navbar-container page-wrapper">

        <h2 class="logo">Event <span>Planner</span></h2>

        <div class="nav-right">
            <a href="{{ route('home') }}" class="btn-primary">Home</a>

            @auth
                <div class="user-menu">
                    <div class="user-trigger">
                        <img
                            src="{{ auth()->user()->profile_image
                                ? asset('storage/'.auth()->user()->profile_image)
                                : asset('images/default-avatar.png') }}"
                            class="avatar"
                        >
                        <div class="user-info">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-email">{{ auth()->user()->email }}</span>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a href="{{ route('profile.edit') }}">View profile</a>
                        <a href="{{ route('registrations.my') }}">My registrations</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Log out</button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn-primary">Register</a>
            @endguest
        </div>

    </div>
</header>
@endif

{{-- ================= CONTENT ================= --}}
<main class="app-content">
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
@if(!in_array(Route::currentRouteName(), ['login', 'register']))
<footer class="footer">
    <h3 class="footer-title">
        Event <span>Planner</span>
    </h3>

    <form class="newsletter">
        <input type="email" placeholder="Enter your mail">
        <button type="submit" class="btn-primary btn-fit">Subscribe</button>
    </form>

    <div class="footer-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('register') }}">Sign UP</a>
        <a href="{{ route('login') }}">Sign in</a>
    </div>

    <hr>

    <p class="footer-copy">
        Non Copyrighted © 2025 Event Planner
    </p>
</footer>
@endif

{{-- 🔥 IMPORTANT : JS STACK --}}
@stack('scripts')

</body>
</html>
