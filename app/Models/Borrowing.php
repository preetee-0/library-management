<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable=[
        'book_id',
        'student_id',
        'student_name',
        'borrow_date',
        'return_date',
        'actual_return_date',
        'returned',
        'fine',
        'fine_paid',
        'fine_paid_at'
    ];
    

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function student(){
        return $this->belongsTo(Student::class,'student_id','student_id');
    }
}