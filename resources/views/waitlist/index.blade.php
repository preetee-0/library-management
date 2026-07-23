@extends('layouts.app')
@section('content')

<div class="container">

    <h2 class="mb-4"><i class="bi bi-hourglass-split"></i> Waitlists</h2>

    @if($waitlists->isEmpty())
        <p class="text-muted">No one is currently waiting for a book.</p>
    @endif

    @foreach($waitlists as $bookId => $entries)
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                {{ $entries->first()->book->title ?? 'Deleted Book' }}
                <span class="badge bg-secondary">{{ $entries->count() }} waiting</span>
            </div>
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entries as $i => $entry)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $entry->student_id }}</td>
                            <td>{{ $entry->student_name }}</td>
                            <td>{{ $entry->email ?? '—' }}</td>
                            <td>{{ $entry->phone ?? '—' }}</td>
                            <td>{{ $entry->created_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="{{ route('waitlist.destroy', $entry->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-success btn-sm" onclick="return confirm('Remove this person from the waitlist? (Do this once they\'ve borrowed the book.)')">
                                        <i class="bi bi-check-circle"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

</div>

@endsection