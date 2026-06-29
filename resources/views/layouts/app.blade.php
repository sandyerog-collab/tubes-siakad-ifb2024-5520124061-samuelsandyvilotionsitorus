<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>@yield('title', 'SIAKAD')</title>

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >
</head>
<body>
    <header class="navbar">
        <div class="navbar-container">
            <a
                href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                class="brand"
            >
                <span class="brand-logo">
                    SA
                </span>

                <span class="brand-text">
                    <strong>SIAKAD</strong>
                    <small>Sistem Informasi Akademik</small>
                </span>
            </a>

            @auth
                <div class="navbar-user">
                    <div class="user-information">
                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <small>
                            {{ ucfirst(auth()->user()->role) }}
                        </small>
                    </div>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="button button-danger button-small"
                        >
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <main class="@yield('container-class', 'container')">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <p>
            &copy; {{ date('Y') }} SIAKAD Sederhana
        </p>
    </footer>
</body>
</html>