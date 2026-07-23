<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
  public function index(Request $request)
{
    $query = Book::query();

    // Search
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('author', 'like', '%' . $request->search . '%')
              ->orWhere('category', 'like', '%' . $request->search . '%');
        });
    }

    // Category Filter
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // Sorting
    switch ($request->sort) {

        case 'az':
            $query->orderBy('title', 'asc');
            break;

        case 'za':
            $query->orderBy('title', 'desc');
            break;

        case 'newest':
            $query->latest();
            break;

        case 'oldest':
            $query->oldest();
            break;

        case 'quantity_high':
            $query->orderBy('quantity', 'desc');
            break;

        case 'quantity_low':
            $query->orderBy('quantity', 'asc');
            break;

        default:
            $query->latest();
    }

    $books = $query->paginate(5);

    $categories = Book::select('category')
                      ->distinct()
                      ->pluck('category');

    return view('books.index', compact('books', 'categories'));
}

    public function create()
    {
        return view('books.create');
    }


    public function store(Request $request)
    {
        $data= $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'quantity' => 'required|integer'
        ]);

if ($request->hasFile('image')) {
    $data['image'] = $request->file('image')->store('books', 'public');
}

Book::create($data);

        return redirect()
    ->route('books.index')
    ->with('success', 'Book added successfully!');
    }


    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }


   public function update(Request $request, Book $book)
{
    $data= $request->validate([
        'title' => 'required',
        'author' => 'required',
        'category' => 'required',
        'quantity' => 'required|integer'
    ]);


if ($request->hasFile('image')) {

    if ($book->image) {
        Storage::disk('public')->delete($book->image);
    }

    $data['image'] = $request->file('image')->store('books', 'public');
}

$book->update($data);

    return redirect()
        ->route('books.index')
        ->with('success', 'Book updated successfully!');
}

    public function destroy(Book $book)
    {
        $book->delete();

      return redirect()
    ->route('books.index')
    ->with('success', 'Book deleted successfully!');
    }
}