<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin | Event Planner</title>
    <link rel="stylesheet" href="{{ asset('css/OB_style.css') }}">
</head>
<body class="admin-bg">

<nav class="admin-navbar">
    <div class="admin-navbar-container">

        {{-- LOGO --}}
        <h2>Event <span>Planner</span> Admin</h2>

        {{-- LINKS --}}
        <ul class="admin-links">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.events.index') }}"
                   class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    Events
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    Categories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.registrations.index') }}"
                   class="{{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                    Registrations
                </a>
            </li>
        </ul>

        {{-- USER MENU (FIGMA STYLE) --}}
        <div class="user-menu">

            {{-- AVATAR --}}
            <img
                src="{{ asset('images/avatar.png') }}"
                alt="avatar"
                class="avatar"
            >

            {{-- NAME + EMAIL --}}
            <div class="user-name">
                {{ auth()->user()->name ?? 'Admin' }} <br>
                <small style="font-weight:400; color:#777;">
                    {{ auth()->user()->email }}
                </small>
            </div>

            {{-- DROPDOWN --}}
            <div class="dropdown">
                <a href="{{ route('profile.edit') }}">View profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Log out</button>
                </form>
            </div>

        </div>
    </div>
</nav>

<main class="admin-content">
    @yield('content')
</main>

</body>
</html>
