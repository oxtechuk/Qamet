<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Car;

echo 'Featured Cars Count: '.Car::where('is_featured', true)->where('is_active', true)->count()."\n";
echo 'Highlighted Cars Count: '.Car::where('is_highlighted', '!=', 'none')->where('is_active', true)->count()."\n";

foreach (Car::where('is_featured', true)->get() as $car) {
    echo "Featured: ID {$car->id}, Name {$car->name}\n";
}
foreach (Car::where('is_highlighted', '!=', 'none')->get() as $car) {
    echo "Highlighted: ID {$car->id}, Name {$car->name}, Status {$car->is_highlighted}\n";
}
