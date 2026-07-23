@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3>Edit Book</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $book->title }}">
                </div>

                <div class="mb-3">
                    <label>Author</label>
                    <input type="text" name="author" class="form-control" value="{{ $book->author }}">
                </div>

                <div class="mb-3">
                    <label>Category</label>
                    <input type="text" name="category" class="form-control" value="{{ $book->category }}">
                </div>

                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="number" name="quantity" class="form-control" value="{{ $book->quantity }}">
                </div>

                <div class="mb-3">
                    <label>Book Cover</label>
                    <input type="file" name="image" class="form-control">

                    @if($book->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$book->image) }}" alt="{{ $book->title }}" style="max-height: 120px; border-radius: 8px;">
                            <p class="small text-muted mb-0">Current cover — uploading a new file will replace this.</p>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Update Book
                </button>

                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>

</form>

        </div>
        </div>
        </div>
    </div>
</div>

@endsection