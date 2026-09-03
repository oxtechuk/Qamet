<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('car_variants')) {
            DB::table('car_variants')
                ->where('image', 'like', '%livewire-tmp%')
                ->update(['image' => null]);
        }

        if (Schema::hasTable('cars')) {
            DB::table('cars')
                ->where('thumbnail', 'like', '%livewire-tmp%')
                ->update(['thumbnail' => null]);
        }
    }

    public function down(): void
    {
        // No-op
    }
};
