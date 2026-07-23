@extends('layouts.app')

@section('content')

<div class="container">
<a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Students
    </a>

    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline-primary btn-sm mb-3">
        <i class="bi bi-pencil"></i> Edit Details
    </a>

    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">
            <h3>{{ $student->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
            <p><strong>Email:</strong> {{ $student->email ?? '—' }}</p>
            <p><strong>Phone:</strong> {{ $student->phone ?? '—' }}</p>
        </div>
    </div>

    <h4 class="mb-3">Borrow History</h4>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Expected Return</th>
                <th>Actual Return</th>
                <th>Status</th>
                <th>Fine</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $borrow)
                <tr>
                    <td>{{ $borrow->book->title ?? 'Deleted Book' }}</td>
                    <td>{{ $borrow->borrow_date }}</td>
                    <td>{{ $borrow->return_date }}</td>
                    <td>
                        @if($borrow->actual_return_date)
                            {{ \Carbon\Carbon::parse($borrow->actual_return_date)->format('Y-m-d') }}
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($borrow->returned)
                            <span class="badge bg-success">Returned</span>
                        @elseif(now()->gt($borrow->return_date))
                            <span class="badge bg-danger">Overdue</span>
                        @else
                            <span class="badge bg-warning text-dark">Borrowed</span>
                        @endif
                    </td>
                    <td>
                        @if($borrow->fine > 0)
                            {{ $borrow->fine_paid ? 'Rs. '.$borrow->fine.' (Paid)' : 'Rs. '.$borrow->fine.' (Unpaid)' }}
                        @else
                            No Fine
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No borrow history yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $borrowings->links() }}
    </div>

</div>

@endsection