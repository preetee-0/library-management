@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2> Library Books</h2>

        <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i>   Add New Book
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

 <form method="GET" action="{{ route('books.index') }}" class="row g-3 mb-4">

    <div class="col-md-4">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search books..."
            value="{{ request('search') }}">
    </div>

    <div class="col-md-3">
        <select name="category" class="form-select">

            <option value="">All Categories</option>

            @foreach($categories as $category)

                <option
                    value="{{ $category }}"
                    {{ request('category')==$category ? 'selected' : '' }}>
                    {{ $category }}
                </option>

            @endforeach

        </select>
    </div>

    <div class="col-md-3">
        <select name="sort" class="form-select">

            <option value="">Sort By</option>

            <option value="az" {{ request('sort')=='az' ? 'selected' : '' }}>
                A - Z
            </option>

            <option value="za" {{ request('sort')=='za' ? 'selected' : '' }}>
                Z - A
            </option>

            <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>
                Newest
            </option>

            <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>
                Oldest
            </option>

            <option value="quantity_high" {{ request('sort')=='quantity_high' ? 'selected' : '' }}>
                Quantity High
            </option>

            <option value="quantity_low" {{ request('sort')=='quantity_low' ? 'selected' : '' }}>
                Quantity Low
            </option>

        </select>
    </div>

    <div class="col-md-2 d-grid">
        <button class="btn btn-primary">
        <i class="bi bi-search"></i>    Search
        </button>
    </div>

</form>
<a href="{{ route('books.index') }}" class="btn btn-secondary mb-3">
    Reset Filters
</a>

    <table class="table table-bordered table-striped table-hover">

        <thead class="table-dark">

            <tr>
                <th>ID</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Status</th>

                <th width="180">Action</th>
            </tr>

        </thead>

        <tbody>

        @forelse($books as $book)

            <tr>

                <td>{{ $book->id }}</td>
                <td>

@if($book->image)

<img
src="{{ asset('storage/'.$book->image) }}"
width="70"
height="90"
class="rounded shadow"
alt="Book Cover">

@else
<img
    src="{{ asset('images/default-book.jpg') }}"
    width="70"
    height="90"
    class="rounded shadow"
    alt="Default Cover">

@endif

</td>

                <td>{{ $book->title }}</td>

                <td>{{ $book->author }}</td>

                <td>{{ $book->category }}</td>

                <td>{{ $book->quantity }}</td>
                <td>
                    @if ($book->quantity==0)
                    <span class ="badge bg-danger">
                        Out of stock
                    </span>
                    @elseif($book->quantity<=5)
                    <span class = "badge bg-warning text-dark">
                        Low Stock </span>
                    @else
                    <span class="badge bg-success">
                        Available
                    </span>

                    @endif
                @if($book->quantity>0)

<a href="{{ route('borrow.create',$book->id) }}"
class="btn btn-success btn-sm">
<i class="bi bi-journal-arrow-down"></i>
Borrow
</a>

@else

<a href="{{ route('waitlist.create', $book->id) }}"
class="btn btn-outline-danger btn-sm">
<i class="bi bi-hourglass-split"></i>
Join Waitlist
</a>


@endif


                </td>
                <td>

                    <a href="{{ route('books.edit', $book->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('books.destroy', $book->id) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this book?')">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="8" class="text-center">
                    No books found.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>
<div class="mt-3">
    {{ $books->withQueryString()->links() }}
</div>
</div>

@endsection