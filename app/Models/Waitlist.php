<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
class Waitlist extends Model{

protected $fillable = [
    'book_id',
    'student_id',
    'student_name',
    'email',
    'phone',
    'fulfilled',

];
public function book(){
    return $this->belongsTo(Book::class);


}}