<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'BAUST Complaint Management')</title>
    <!-- Inline theme script to prevent any flash of wrong/unstyled theme on reload -->
    <script>
        (function() {
            try {
                var stored = localStorage.getItem('baust-theme');
                if (stored === 'dark' || stored === 'light') {
                    document.documentElement.setAttribute('data-theme', stored);
                } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                } else {
                    document.documentElement.setAttribute('data-theme', 'light');
                }
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="topbar">
        <nav class="nav">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark">B</span>
                <span>BAUST <span class="brand-subtitle">| Complaints</span></span>
            </a>
            <div class="navlinks">
                @auth
                    <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    @if (auth()->user()->role === 'student')
                        <a class="{{ request()->routeIs('complaints.*') ? 'active' : '' }}" href="{{ route('complaints.index') }}">My Complaints</a>
                        <a class="{{ request()->routeIs('complaints.create') ? 'active' : '' }}" href="{{ route('complaints.create') }}">Submit Complaint</a>
                    @else
                        <a class="{{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}" href="{{ route('admin.complaints.index') }}">Assigned Complaints</a>
                    @endif
                    @if (auth()->user()->role === 'super_admin')
                        <a class="{{ request()->routeIs('superadmin.categories*') ? 'active' : '' }}" href="{{ route('superadmin.categories') }}">Categories</a>
                        <a class="{{ request()->routeIs('superadmin.administrators*') ? 'active' : '' }}" href="{{ route('superadmin.administrators') }}">Administrators</a>
                    @endif
                    <span class="nav-user">{{ auth()->user()->name }}</span>
                    <form class="navform" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Log out</button>
                    </form>
                @else
                    <a class="{{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Log in</a>
                    <a class="btn smallbtn secondary" href="{{ route('register') }}">Student Register</a>
                @endauth
                <button
                    id="theme-toggle"
                    class="theme-toggle"
                    type="button"
                    aria-label="Switch theme"
                    title="Switch theme"
                >☾</button>
            </div>
        </nav>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if (isset($errors) && $errors->any())
            <div class="alert errorbox">
                <strong>Please correct the following:</strong>
                <ul style="margin: 6px 0 0; padding-left: 20px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Global Day/Night Lightbox Modal for Attachment Images -->
    <div id="image-lightbox" class="lightbox-modal" role="dialog" aria-modal="true" aria-label="Evidence preview">
        <div class="lightbox-backdrop"></div>
        <div class="lightbox-panel">
            <button id="lightbox-close" class="lightbox-close-btn" type="button" aria-label="Close preview">✕</button>
            <div class="lightbox-img-wrap">
                <img id="lightbox-image" class="lightbox-img" src="" alt="Evidence preview" />
            </div>
            <div class="lightbox-footer">
                <span id="lightbox-caption" class="lightbox-caption"></span>
                <a id="lightbox-download" class="btn smallbtn secondary" href="#" download>Download original</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        BAUST Complaint Management System · Bangladesh Army University of Science and Technology · © {{ date('Y') }}
    </footer>
</body>
</html>
