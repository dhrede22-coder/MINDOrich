@extends('layouts.auth')

@section('title', 'Register')

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
                Create an account
            </h2>

            <p class="text-muted">
                Join MINDOrich today
            </p>

        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">

                <label class="form-label">Name</label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    required
                    autofocus>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">Email Address</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required>

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">Password</label>

                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="mb-4">

                <label class="form-label">Confirm Password</label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    required>

                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <button type="submit" class="btn btn-warning w-100 fw-bold">
                Register
            </button>

        </form>

        <div class="text-center mt-4">

            <a href="{{ route('login') }}" class="text-decoration-none">
                Already have an account? Login
            </a>

        </div>

    </div>

</div>

@endsection
