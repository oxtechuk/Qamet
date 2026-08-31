<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('action', 50); // created, updated, deleted, completed, status_changed, login, etc.
            $table->string('subject_type', 100)->nullable(); // Car, Booking, Task, Lead, Employee, Setting, etc.
            $table->string('subject_id', 100)->nullable();
            $table->string('subject_title', 255)->nullable();
            $table->text('description')->nullable();
            $table->json('properties')->nullable(); // old & new values or extra details
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['employee_id', 'created_at']);
            $table->index(['action', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
