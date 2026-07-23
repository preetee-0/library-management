@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Borrow History
    </h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped table-hover">

        <thead class="table-dark">

            <tr>
                <th><i class="bi bi-book"></i> Book</th>
                <th>Student ID</th>
                <th><i class="bi bi-person"></i> Student</th>
                <th><i class="bi bi-calendar-event"></i> Borrow Date</th>
                <th><i class="bi bi-calendar-check"></i> Expected Return</th>
                <th><i class="bi bi-check2-circle"></i> Actual Return</th>
                <th><i class="bi bi-info-circle"></i> Status</th>
                <th><i class="bi bi-cash-stack"></i> Fine</th>
                <th><i class="bi bi-gear"></i> Action</th>
            </tr>

        </thead>

        <tbody>

        @foreach($borrowings as $borrow)

            <tr>

                <td>{{ $borrow->book->title }}</td>
                <td>{{ $borrow->student_id }}</td>

                <td>
                    @if($borrow->student)
                        <a href="{{ route('students.show', $borrow->student->id) }}">{{ $borrow->student_name }}</a>
                    @else
                        {{ $borrow->student_name }}
                    @endif
                </td>

                <td>{{ $borrow->borrow_date }}</td>

                <td>{{ $borrow->return_date }}</td>

                {{-- Actual Return Date --}}
                <td>
                    @if ($borrow->actual_return_date)
                    {{ \Carbon\Carbon::parse($borrow->actual_return_date)->format('Y-m-d') }}
             

                    @else
                    <span class="text-muted">-</span>
                    
                    @endif
                       </td>

                {{-- Status --}}
                <td>

                    @if($borrow->returned)

                        <span class="badge bg-success">
                            Returned
                        </span>

                    @elseif(now()->gt($borrow->return_date))

                        <span class="badge bg-danger">
                            Overdue
                        </span>

                    @else

                        <span class="badge bg-warning text-dark">
                            Borrowed
                        </span>

                    @endif

                </td>

{{-- Fine --}}
<td>

    @if($borrow->fine > 0)

        @if($borrow->fine_paid)

            <span class="text-success fw-bold">
                <i class="bi bi-check-circle"></i>
                Rs. {{ $borrow->fine }} (Paid)
            </span>

        @else

            <div>
                <span class="text-danger fw-bold d-block mb-1">
                    Rs. {{ $borrow->fine }} (Unpaid)
                </span>

                <form action="{{ route('borrow.payFine', $borrow->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-success btn-sm">
                        Mark as Paid
                    </button>
                </form>
            </div>

        @endif

    @elseif(!$borrow->returned && now()->gt($borrow->return_date))

        @php
            $estimatedDaysLate = abs(now()->diffInDays($borrow->return_date, true));
            $estimatedFine = $estimatedDaysLate * 10;
        @endphp

        <span class="text-warning fw-bold">
            Rs. {{ $estimatedFine }} (estimated, accruing)
        </span>

    @else

        <span class="text-success">
            No Fine
        </span>

    @endif



</td>

                {{-- Action --}}
                <td>

                    @if(!$borrow->returned)

                        <form action="{{ route('borrow.return',$borrow->id) }}" method="POST">

                            @csrf

                            <button class="btn btn-primary btn-sm">

                                <i class="bi bi-arrow-return-left"></i>

                                Return

                            </button>

                        </form>

                    @else

                        <span class="text-success">

                            <i class="bi bi-check-circle-fill"></i>

                            Returned

                        </span>

                    @endif

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

    <div class="mt-3">
        {{ $borrowings->links() }}
    </div>

</div>

@endsection