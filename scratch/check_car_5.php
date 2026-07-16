<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Car;

$car = Car::find(5);
if ($car) {
    echo "ID 5 - Name: {$car->name}\n";
    echo 'ID 5 - Is Featured: '.($car->is_featured ? 'YES' : 'NO')."\n";
    echo "ID 5 - Updated At: {$car->updated_at}\n";
} else {
    echo "Car ID 5 not found\n";
}
