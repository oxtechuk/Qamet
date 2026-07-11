<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Car;

echo "--- Testing Unicode Slugify ---\n";
$ref = new ReflectionMethod(Car::class, 'slugify');
$ref->setAccessible(true);

$testCases = [
    'Hyundai Azera Classic 2026' => 'hyundai-azera-classic-2026',
    'هيونداي أزيرا كلاسيك 2026' => 'هيونداي-أزيرا-كلاسيك-2026',
    'Kia Sportage !!! 2025' => 'kia-sportage-2025',
    'كيا سبورتاج 2025' => 'كيا-سبورتاج-2025'
];

foreach ($testCases as $input => $expected) {
    $result = $ref->invoke(null, $input);
    if ($result === $expected) {
        echo "PASS: '$input' => '$result'\n";
    } else {
        echo "FAIL: '$input' => '$result' (Expected: '$expected')\n";
    }
}

echo "\n--- Testing generateUniqueSlug logic ---\n";
// Let's test English slug generation with no duplication of year
$enSlug1 = Car::generateUniqueSlug('Hyundai Azera Classic 2026', 2026, 'en');
echo "En Slug (with year already in name): $enSlug1\n";

$enSlug2 = Car::generateUniqueSlug('Hyundai Azera Classic', 2026, 'en');
echo "En Slug (without year in name): $enSlug2\n";

// Let's test Arabic slug generation
$arSlug1 = Car::generateUniqueSlug('هيونداي أزيرا كلاسيك 2026', 2026, 'ar');
echo "Ar Slug (with year already in name): $arSlug1\n";

$arSlug2 = Car::generateUniqueSlug('هيونداي أزيرا كلاسيك', 2026, 'ar');
echo "Ar Slug (without year in name): $arSlug2\n";

echo "\n--- Testing DB Query with translated slugs ---\n";
$firstCar = Car::first();
if ($firstCar) {
    echo "First Car ID: {$firstCar->id}\n";
    echo "First Car Name (EN): {$firstCar->getTranslation('name', 'en')}\n";
    echo "First Car Name (AR): {$firstCar->getTranslation('name', 'ar')}\n";
    echo "First Car Slug (EN): {$firstCar->getTranslation('slug', 'en')}\n";
    echo "First Car Slug (AR): {$firstCar->getTranslation('slug', 'ar')}\n";

    // Try finding by the English slug
    $foundByEn = Car::where(function($q) use ($firstCar) {
        $q->where('slug->en', $firstCar->getTranslation('slug', 'en'))
          ->orWhere('slug->ar', $firstCar->getTranslation('slug', 'en'));
    })->first();
    echo "Query by En Slug found Car: " . ($foundByEn ? "YES (ID {$foundByEn->id})" : "NO") . "\n";
} else {
    echo "No cars found in database.\n";
}

echo "\nVerification script completed.\n";
