<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->date('started_at')->nullable()->change();
            $table->unsignedBigInteger('contact_source_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->date('started_at')->nullable(false)->change();
            $table->unsignedBigInteger('contact_source_id')->nullable(false)->change();
        });
    }
};
