@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-lg border-0">

                <div class="card-header bg-primary text-white">

                    <h3 class="mb-0">
                    <i class="bi bi-book"></i>    Add New Book
                    </h3>

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

                    <form action="{{ route('books.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Book Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                value="{{ old('title') }}"
                                placeholder="Enter book title">

                        </div>

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Author
                            </label>

                            <input
                                type="text"
                                name="author"
                                class="form-control"
                                value="{{ old('author') }}"
                                placeholder="Enter author name">

                        </div>

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Category
                            </label>

                            <input
                                type="text"
                                name="category"
                                class="form-control"
                                value="{{ old('category') }}"
                                placeholder="Example: Novel, Crime, History">

                        </div>

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Quantity
                            </label>

                            <input
                                type="number"
                                name="quantity"
                                class="form-control"
                                value="{{ old('quantity') }}"
                                placeholder="Enter quantity">

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Book Cover
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control">

                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('books.index') }}"
                               class="btn btn-secondary">
                                 Back
                            </a>

                            <button
                                type="submit"
                                class="btn btn-success">
                                 Save Book
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection