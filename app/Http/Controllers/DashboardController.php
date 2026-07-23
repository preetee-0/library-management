<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();

        $totalCategories = Book::distinct('category')
            ->count('category');

        $totalQuantity = Book::sum('quantity');

        $latestBook = Book::latest()->first();

        $recentBooks = Book::latest()
            ->take(5)
            ->get();
        $topBooks = Borrowing::selectRaw('book_id, count(*) as borrow_count')
            ->groupBy('book_id')
            ->orderByDesc('borrow_count')
            ->take(5)
            ->with('book')
            ->get();
        $topBooksLabels = $topBooks->map(fn($b) => $b->book->title ?? 'Deleted Book');
        $topBooksData = $topBooks->pluck('borrow_count');

                $returnedCount = Borrowing::where('returned', true)->count();
        $overdueCount = Borrowing::where('returned', false)
            ->where('return_date', '<', now())
            ->count();
        $activeCount = Borrowing::where('returned', false)
            ->where('return_date', '>=', now())
            ->count();
        $finesPaid = Borrowing::where('fine_paid', true)->sum('fine');
        $finesUnpaid = Borrowing::where('fine_paid', false)->where('fine', '>', 0)->sum('fine');

        return view('dashboard', compact(
            'totalBooks',
            'totalCategories',
            'totalQuantity',
            'latestBook',
            'recentBooks',
            'topBooksLabels',
            'topBooksData',
            'returnedCount',
            'overdueCount',
            'activeCount',
            'finesPaid',
            'finesUnpaid'
        ));
    }
}