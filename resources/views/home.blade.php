@extends('layouts.app')
@section('content')

<div class="text-center py-5">

    <i class="bi bi-building" style="font-size: 4rem;"></i>

    <h1 class="mt-3 mb-2">Library Management System</h1>
    <p class="mt-3 mb-2">Track books, manage borrowings, and keep your library organized.</p>

    <div class="row justify-content-center mb-5">
        <div class="col-md-3 mb-3">
            <a href="{{ route('books.index') }}" class="text-decoration-none text-reset">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <i class="bi bi-book text-primary" style="font-size: 2rem;"></i>
                        <h3 class="mt-2">{{ $totalbooks }}</h3>
                        <p class=" mb-0">Books in Catalog</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('students.index') }}" class="text-decoration-none text-reset">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <i class="bi bi-people text-success" style="font-size: 2rem;"></i>
                        <h3 class="mt-2">{{ $totalstudents }}</h3>
                        <p class=" mb-0">Registered Students</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('borrow.index') }}" class="text-decoration-none text-reset">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <i class="bi bi-clock-history text-warning" style="font-size: 2rem;"></i>
                        <h3 class="mt-2">{{ $activeborrowings }}</h3>
                        <p class=" mb-0">Books Currently Borrowed</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg me-2">
        <i class="bi bi-speedometer2"></i> Go to Dashboard
    </a>
    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-lg">
        <i class="bi bi-book"></i> Browse Books
    </a>

</div>

@endsection