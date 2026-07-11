<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->text('note');
            $table->enum('type', ['note', 'call', 'status_change'])->default('note');
            $table->string('old_status')->nullable(); // للـ status_change
            $table->string('new_status')->nullable(); // للـ status_change
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_notes');
    }
};
