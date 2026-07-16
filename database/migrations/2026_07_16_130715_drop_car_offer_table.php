<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Pivot table kept for backward compatibility with Blade views.
        // API and Filament now use car_id FK only.
    }

    public function down(): void
    {
        //
    }
};
