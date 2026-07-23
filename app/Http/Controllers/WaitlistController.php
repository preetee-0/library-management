<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Waitlist;
use App\Models\Student;
use Illuminate\Http\Request;

class WaitlistController extends Controller
{
    public function create(Book $book)
    {
        return view('waitlist.create', compact('book'));
    }

    public function store(Request $request, Book $book)
    {
        $data = $request->validate([
            'student_id' => 'required',
            'student_name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);
        $student = Student::where('student_id', $data['student_id'])->first();

        if ($student) {
            if (strcasecmp(trim($student->name), trim($data['student_name'])) !== 0) {
                return back()
                    ->withErrors(['student_name' => 'Student ID "'.$data['student_id'].'" is registered to "'.$student->name.'". Please enter the correct name for this student ID.'])
                    ->withInput();
            }
// update email and phonr
            $student->email = $student->email ?? $data['email'];
            $student->phone = $student->phone ?? $data['phone'];
            $student->save();
        } else {
            Student::create([
                'student_id' => $data['student_id'],
                'name' => $data['student_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);
        }

        $alreadyWaiting = Waitlist::where('book_id', $book->id)
            ->where('student_id', $data['student_id'])
            ->where('fulfilled', false)
            ->exists();

        if ($alreadyWaiting) {
            return back()->with('error', 'You are already on the waitlist for "'.$book->title.'".');
        }

        $data['book_id'] = $book->id;
        Waitlist::create($data);

        $position = Waitlist::where('book_id', $book->id)
            ->where('fulfilled', false)
            ->count();

        return redirect()
            ->route('books.index')
            ->with('success', 'Added to the waitlist for "'.$book->title.'". Position in queue: '.$position.'.');
    }
    public function index()
    {
        $waitlists = Waitlist::with('book')
            ->where('fulfilled', false)
            ->orderBy('book_id')
            ->orderBy('created_at')
            ->get()
            ->groupBy('book_id');

        return view('waitlist.index', compact('waitlists'));
    }
//remove from waitlist
    public function destroy(Waitlist $waitlist)
    {
        $waitlist->delete();

        return back()->with('success', 'Removed from the waitlist.');
    }
}