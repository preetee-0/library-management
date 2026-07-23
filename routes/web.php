<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WaitlistController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Book routes
    Route::resource('books', BookController::class);

    // Borrow routes
    Route::get('/borrow/{book}', [BorrowController::class, 'create'])->name('borrow.create');
    Route::post('/borrow/{book}', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/borrowings', [BorrowController::class, 'index'])->name('borrow.index');
    Route::post('/return/{borrowing}', [BorrowController::class, 'returnBook'])->name('borrow.return');
    Route::post('/pay-fine/{borrowing}', [BorrowController::class, 'payFine'])->name('borrow.payFine');
    Route::get('/check-user/{studentId}', [BorrowController::class, 'checkUser'])->name('check.user');

    // Student routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');

    // Waitlist routes
    Route::get('/waitlist', [WaitlistController::class, 'index'])->name('waitlist.index');
    Route::get('/books/{book}/waitlist', [WaitlistController::class, 'create'])->name('waitlist.create');
    Route::post('/books/{book}/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');
    Route::delete('/waitlist/{waitlist}', [WaitlistController::class, 'destroy'])->name('waitlist.destroy');
});