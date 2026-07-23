<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Student;
use Illuminate\Http\Request;
class BorrowController extends Controller
{
    // Show Borrow Form
    public function create(Book $book)
    {
        return view('borrow.create', compact('book'));
    }

    // Save Borrow Record
    public function store(Request $request, Book $book)
    {
  

        $request->validate([
         
            'student_id'=>'required',
            'student_name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
                ]);
        if ($book->quantity < 1) {
        return back()->with('error', 'No copies of "'.$book->title.'" are currently available to borrow.');
}
       // Check the student_id against the students table (auto-register if new)
        $student = Student::where('student_id', $request->student_id)->first();

        if ($student) {
            if (strcasecmp(trim($student->name), trim($request->student_name)) !== 0) {
                return back()
                    ->withErrors(['student_name' => 'Student ID "'.$request->student_id.'" is registered to "'.$student->name.'". Please enter the correct name for this student ID.'])
                    ->withInput();
            }

            // Fill in email/phone if they were missing before and are now provided
            $student->email = $student->email ?? $request->email;
            $student->phone = $student->phone ?? $request->phone;
            $student->save();
        } else {
            $student = Student::create([
                'student_id' => $request->student_id,
                'name' => $request->student_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }
        $maxActiveBorrowings = 3;
        $activeBorrowings = Borrowing::where('student_id', $request->student_id)
        ->where('returned',false)
        ->count();
        if( $activeBorrowings >= $maxActiveBorrowings ) {
            return back()
                ->withErrors(['student_id' => $student->name.' ('.$request->student_id.') already has '.$activeBorrowings.' book(s) borrowed and has reached the limit of '.$maxActiveBorrowings.'. Please return a book before borrowing another.'])
                ->withInput();
            }
              $existingBorrow = Borrowing::where('student_id',$request->student_id)->first();
        $rules = [
            'student_id'=> 'required|string',
            'student_name'=> 'required|string',
            'borrow_date'=> 'required|date',
            'return_date'=> 'required|date|after_or_equal:borrow_date',
        ];
        if (!$existingBorrow){
            $rules['email'] = 'required|email|unique:students,email';
            $rules['phone'] = 'required|string|unique:students,phone';
        }
        else {
        $rules['email']= 'nullable|email|unique:students,email'.$student->id;
        $rules['phone'] = 'nullable|string|unique:students,phone'.$student->id;
        }
        $validated =$request->validate($rules);
        if ($existingBorrow){
        $validated['email'] = $validated['email']?? $existingBorrow->email;
        $validated['phone'] = $validated['phone']?? $existingBorrow->phone;
        }
        $validated['book_id'] = $book->id;
        $borrow = Borrowing::create($validated);

    


        Borrowing::create([
            'book_id' => $book->id,
            'student_id'=> $request->student_id,
            'student_name' => $request->student_name,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
        ]);

        // Reduce quantity
        $book->quantity--;
        $book->save();

        return redirect()
            ->route('books.index')
            ->with('success', $book->title. ' has been  borrowed successfully by '. $request->student_name .' . Remaining copies: '.$book->quantity.'.');
    }
public function index()
{

    $borrowings = Borrowing::with('book')
                    ->latest()
                    ->paginate(10);

    return view('borrow.index', compact('borrowings'));

}



public function returnBook(Borrowing $borrowing)
{

    if(!$borrowing->returned)
    {

        $today = Carbon::today();

        $dueDate = Carbon::parse($borrowing->return_date);

        $daysLate = 0;

        if($today->gt($dueDate))
        {
            $daysLate = abs($today->diffInDays($dueDate,true));
        }

        $fine = $daysLate * 10;

        $borrowing->returned = true;

        $borrowing->actual_return_date = $today;

        $borrowing->fine = $fine;

        $borrowing->save();

        $book = $borrowing->book;

        $book->quantity++;

        $book->save();

        $message = 'Book returned successfully. Fine: Rs. '.$fine;

        $nextInLine = \App\Models\Waitlist::where('book_id', $book->id)
            ->where('fulfilled', false)
            ->oldest()
            ->first();

        if ($nextInLine) {
            $message .= ' Note: '.$nextInLine->student_name.' ('.$nextInLine->student_id.') is next on the waitlist for this book.';
        }

        return redirect()
            ->route('borrow.index')
            ->with('success', $message);
    }

    return back();
}
public function payFine(Borrowing $borrowing)  {
    if ($borrowing->fine >0 && !$borrowing->fine_paid) {
    $borrowing->fine_paid=true;
    $borrowing->fine_paid_at = now();
    $borrowing->save();
    return back()->with('success','Fine of Rs '.$borrowing->fine. 'marked as paid.');

    }
    return back();
    
}
public function checkUser($student_id){
    $borrow = Borrowing:: where('student_id', $student_id)->first();
    if ($borrow) {
        return response()->json([
            'exists'=>True,
            'user'=>['email'=>$borrow->email,
            'phone'=> $borrow->phone,
            'name'=> $borrow->student_name ]
        ]);

}
return response()->json(['exist'=>false]);
}
}