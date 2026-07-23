<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::withCount('borrowings');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('student_id', 'like', '%'.$request->search.'%');
            });
        }

        $students = $query->orderBy('name')->paginate(10);

        return view('students.index', compact('students'));
    }

    public function show(Student $student)
    {
        $borrowings = $student->borrowings()->with('book')->latest()->paginate(10);

        return view('students.show', compact('student', 'borrowings'));
    }
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'student_id' => 'required|string|unique:students,student_id,'.$student->id,
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $student->update($data);

        return redirect()
            ->route('students.show', $student->id)
            ->with('success', 'Student details updated successfully!');
    }
}