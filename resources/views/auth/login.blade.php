@extends('layouts.app')

@section('title', 'Login - SIAKAD')

@section('container-class', 'auth-container')

@section('content')
    <section class="login-card">
        <div class="login-header">
            <div class="login-logo">
                SA
            </div>

            <h1>Selamat Datang</h1>

            <p>
                Silakan login untuk masuk ke Sistem Informasi Akademik.
            </p>
        </div>

        <form
            action="{{ route('login.process') }}"
            method="POST"
            class="form"
        >
            @csrf

            <div class="form-group">
                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    class="form-control @error('email') input-error @enderror"
                    autocomplete="email"
                    autofocus
                    required
                >

                @error('email')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    class="form-control @error('password') input-error @enderror"
                    autocomplete="current-password"
                    required
                >

                @error('password')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <label class="checkbox-wrapper">
                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                >

                <span>Ingat saya</span>
            </label>

            <button
                type="submit"
                class="button button-primary button-full"
            >
                Login
            </button>
        </form>
        </div>
    </section>
@endsection