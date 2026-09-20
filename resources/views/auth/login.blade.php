@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="card shadow border-0 rounded-4">

    <div class="card-body p-5">

        <div class="text-center mb-4">

            <img
                src="{{ asset('image/logo/mindorich-logo.png') }}"
                width="90"
                class="mb-3"
                alt="MINDOrich Logo">

            <h2 class="fw-bold text-warning">
                Welcome Back
            </h2>

            <p class="text-muted">
                Sign in to continue
            </p>

        </div>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required
                    autofocus>

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <div class="position-relative">

    <input
        type="password"
        id="login-password"
        name="password"
        class="form-control pe-5 @error('password') is-invalid @enderror"
        required
    >

    <button
        type="button"
        id="toggle-login-password"
        class="password-toggle-btn"
        aria-label="Show password"
    >
        <i class="bi bi-eye"></i>
    </button>

</div>

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-check mb-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    id="remember">

                <label class="form-check-label" for="remember">
                    Remember Me
                </label>

            </div>

            <button
                type="submit"
                class="btn btn-warning w-100 fw-bold">

                Login

            </button>

        </form>

        <div class="text-center mt-4">

            <a href="{{ url('/') }}" class="text-decoration-none">
                ← Back to Home
            </a>

        </div>

        <div class="text-center mt-2">
            <a href="{{ route('register') }}" class="text-decoration-none">
                Don't have an account? Sign Up
            </a>
        </div>

    </div>

</div>

<style>
    .password-toggle-btn {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        padding: 4px;
        margin: 0;
        color: #6c757d;
        font-size: 18px;
        line-height: 1;
        cursor: pointer;
    }

    .password-toggle-btn:hover {
        color: #333;
    }

    .password-toggle-btn:focus {
        outline: none;
        box-shadow: none;
    }
</style>
<script>
    document
        .getElementById('toggle-login-password')
        .addEventListener('click', function () {

            const password = document.getElementById('login-password');
            const icon = this.querySelector('i');

            if (password.type === 'password') {

                password.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
                this.setAttribute('aria-label', 'Hide password');

            } else {

                password.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
                this.setAttribute('aria-label', 'Show password');

            }
        });
</script>

@endsection