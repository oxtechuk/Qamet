<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CalculatorDefaultsSeeder::class);
        $this->call(ContactSourcesSeeder::class);
        $this->call(CarSeeder::class);
        $this->call(CarSpecsAndFeaturesSeeder::class);
        $this->call(AboutContentSeeder::class);
        $this->call(HomeContentSeeder::class);
        $this->call(BlogCategorySeeder::class);
        $this->call(BlogPostSeeder::class);
    }
}
