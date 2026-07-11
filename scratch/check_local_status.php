<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Car;

foreach ([2, 3, 4] as $id) {
    $car = Car::find($id);
    if ($car) {
        echo "ID {$id} - Name: {$car->name}, Featured: " . ($car->is_featured ? 'YES' : 'NO') . "\n";
    }
}
