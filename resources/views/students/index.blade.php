@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4"><i class="bi bi-people"></i> Students</h2>

    <form method="GET" action="{{ route('students.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or student ID" value="{{ request('search') }}">
            <button class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
        </div>
    </form>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Total Borrows</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email ?? '—' }}</td>
                    <td>{{ $student->phone ?? '—' }}</td>
                    <td>{{ $student->borrowings_count }}</td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No students found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $students->links() }}
    </div>

</div>

@endsection