<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('borrowings', function (Blueprint $table) {

        $table->id();

        $table->foreignId('book_id')->constrained()->onDelete('cascade');

        $table->string('student_name');

        $table->date('borrow_date');

        $table->date('return_date');

        $table->boolean('returned')->default(false);

        $table->decimal('fine',8,2)->default(0);

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
