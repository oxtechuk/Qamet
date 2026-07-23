<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Car;

$count = Car::where('is_featured', true)->where('is_active', true)->count();
echo "Active Featured Cars Count: {$count}\n";

foreach (Car::where('is_featured', true)->get() as $car) {
    echo "ID: {$car->id}, Name: {$car->name}, Active: ".($car->is_active ? 'YES' : 'NO')."\n";
}
