{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark">
                        <i class="bi bi-person"></i>Create Account</h2>
                    <p class="text-muted">Join our library community today</p>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            <i class="bi bi-person me-1"></i> Full Name
                        </label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            value="{{ old('name') }}"
                            required 
                            class="form-control form-control-lg rounded-pill @error('name') is-invalid @enderror" 
                            placeholder="enter  your name"
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                            class="form-control form-control-lg rounded-pill @error('email') is-invalid @enderror" 
                            placeholder="your@email.com"
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            <i class="bi bi-lock me-1"></i> Password
                        </label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            class="form-control form-control-lg rounded-pill @error('password') is-invalid @enderror" 
                            placeholder="Minimum 8 characters"
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            <i class="bi bi-check-circle me-1"></i> Confirm Password
                        </label>
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            required 
                            class="form-control form-control-lg rounded-pill" 
                            placeholder="Confirm your password"
                        >
                    </div>

                    <button 
                        type="submit" 
                        class="btn btn-primary btn-lg w-100 rounded-pill fw-semibold"
                    >
                        <i class="bi bi-person-plus me-2"></i> Create Account
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted small">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection