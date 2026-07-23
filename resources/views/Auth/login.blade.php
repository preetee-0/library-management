{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark">
                        <i class="bi bi-person"></i>Welcome Back!</h2>
                    <p class="text-muted">Sign in to manage your library account</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            <i class="bi bi-envelope me-1"></i> Email Address
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                            class="form-control form-control-lg rounded-pill @error('email') is-invalid @enderror" 
                            placeholder="your@email.com"
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label fw-semibold mb-0">
                                <i class="bi bi-lock me-1"></i> Password
                            </label>
                            <a href="#" class="text-decoration-none small">Forgot password?</a>
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            class="form-control form-control-lg rounded-pill @error('password') is-invalid @enderror" 
                            placeholder="••••••••"
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            class="form-check-input"
                        >
                        <label for="remember" class="form-check-label">
                            Keep me logged in
                        </label>
                    </div>

                    <button 
                        type="submit" 
                        class="btn btn-primary btn-lg w-100 rounded-pill fw-semibold"
                    >
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted small">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
                            Register here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection