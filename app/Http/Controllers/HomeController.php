<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Student;
use App\Models\Borrowing;
class HomeController extends Controller{
public function index(){
    $totalbooks = Book::count();
    $totalstudents = Student::count();
    $activeborrowings=Borrowing::where('returned',false)->count();
    return view('home',compact('totalbooks','totalstudents','activeborrowings'));

}
}