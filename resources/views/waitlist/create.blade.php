@extends('layouts.app')
@section('content')

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h3>Join Waitlist</h3>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h4>{{ $book->title }}</h4>
            <p class="text-muted">This book currently has 0 copies available. You'll be added to the waitlist and contacted when a copy is returned.</p>

            <form action="{{ route('waitlist.store', $book->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Student ID</label>
                    <input type="text" name="student_id" class="form-control" placeholder="Example: STU098" value="{{ old('student_id') }}" required>
                </div>
                <div class="mb-3">
                    <label>Student Name</label>
                    <input type="text" name="student_name" class="form-control" value="{{ old('student_name') }}" required>
                </div>
                <div class="mb-3">
                    <label>Email <small class="text-muted">(optional)</small></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label>Phone <small class="text-muted">(optional)</small></label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <button class="btn btn-danger">Join Waitlist</button>
            </form>

        </div>
    </div>
</div>

@endsection