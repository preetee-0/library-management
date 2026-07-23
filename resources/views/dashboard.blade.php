@extends('layouts.app')

@section('content')

<h2 class="mb-4">Library Dashboard</h2>
<div class="row">

    <!-- Total Books -->
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body text-center">
                <h5 class="card-title"> Total Books</h5>
                <h1>{{ $totalBooks }}</h1>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success shadow">
            <div class="card-body text-center">
                <h5 class="card-title"> Categories</h5>
                <h1>
                <i class="bi bi-book-half text-primary"></i>{{ $totalCategories }}</h1>
            </div>
        </div>
    </div>

    <!-- Quantity -->
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-warning shadow">
            <div class="card-body text-center">
                <h5 class="card-title"> Quantity</h5>
                <h1>{{ $totalQuantity }}</h1>
            </div>
        </div>
    </div>

</div>
<div class="row mt-4">


    <div class="col-md-8 mb-4">
        <div class="card border-success shadow h-100">

            <div class="card-header bg-success text-white">
                 Recently Added Books
            </div>

            <div class="card-body">

                <ul class="list-group">

                    @foreach($recentBooks as $book)

                        <li class="list-group-item">
                             {{ $book->title }}
                        </li>

                    @endforeach

                </ul>

            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-primary shadow">
            <div class="card-header bg-primary text-white">
                 Latest Book
            </div>

            <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 100px;">
                @if($latestBook)
                    <h4 class="mb-0 text-center">
                        <i class="bi bi-bookmark-star text-primary"></i>
                        {{ $latestBook->title }}
                    </h4>
                @else
                    <p class="mb-0">No books available.</p>
                @endif
            </div>
        </div>
    </div>

    </div>

<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-dark text-white">
                Top 5 Most-Borrowed Books
            </div>
            <div class="card-body">
                <canvas id="topBooksChart"></canvas>
            </div>
            </div>
        </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-dark text-white">
                Borrowing Status
            </div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-dark text-white">
                Fines: Paid vs Outstanding
            </div>
            <div class="card-body">
                <canvas id="finesChart"></canvas>
            </div>
        </div>
    </div>
</div>


<div class="text-center mt-4">
    <a href="{{ route('books.index') }}" class="btn btn-primary">
        View Books
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('topBooksChart'), {
        type: 'bar',
        data: {
            labels: @json($topBooksLabels),
            datasets: [{
                label: 'Times Borrowed',
                data: @json($topBooksData),
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Returned', 'Overdue', 'Active (not yet due)'],
            datasets: [{
                data: [{{ $returnedCount }}, {{ $overdueCount }}, {{ $activeCount }}],
                backgroundColor: ['#198754', '#dc3545', '#ffc107']
            }]
        },
        options: { responsive: true }
    });

    new Chart(document.getElementById('finesChart'), {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Outstanding'],
            datasets: [{
                data: [{{ $finesPaid }}, {{ $finesUnpaid }}],
                backgroundColor: ['#198754', '#dc3545']
            }]
        },
        options: { responsive: true }
    });
</script>

@endsection