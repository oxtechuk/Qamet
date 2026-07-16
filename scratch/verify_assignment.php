<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;
use App\Models\Car;
use App\Models\Employee;
use App\Models\Setting;
use App\Services\BookingAssignmentService;

echo "--- Verification of Booking Assignment with Sales / Sales-Rep Roles ---\n";

// Enable auto assign in settings table
$prevAutoAssign = Setting::where('key', 'auto_assign_bookings')->first();
Setting::updateOrCreate(['key' => 'auto_assign_bookings'], ['value' => '1']);

// Retrieve existing active sales/sales-reps or create test ones
$initialSalesRepsCount = Employee::whereIn('role', ['sales', 'sales-rep'])->where('is_active', true)->count();
echo "Initial sales/sales-rep active employees count: {$initialSalesRepsCount}\n";

// Let's create a test 'sales-rep' employee if none exist
$testRep = Employee::where('email', 'test_rep@example.com')->first();
if (! $testRep) {
    $testRep = Employee::create([
        'name' => 'Test Sales Rep',
        'email' => 'test_rep@example.com',
        'password' => bcrypt('password123'),
        'role' => 'sales-rep',
        'is_active' => true,
    ]);
    $testRep->assignRole('sales-rep');
    echo "Created a temporary 'sales-rep' employee: ID {$testRep->id}\n";
} else {
    echo "Temporary 'sales-rep' employee already exists: ID {$testRep->id}\n";
}

// Fetch all active reps to check ordering
$allReps = Employee::whereIn('role', ['sales', 'sales-rep'])->where('is_active', true)->orderBy('id')->get();
echo "Active sales reps in system:\n";
foreach ($allReps as $rep) {
    echo " - ID: {$rep->id}, Name: {$rep->name}, Role: {$rep->role}\n";
}

// Get first car ID to satisfy DB constraints
$car = Car::first();
if (! $car) {
    echo "ERROR: No cars found in database. Please run seeders first.\n";
    exit(1);
}
echo "Using Car ID: {$car->id} for test bookings.\n";

// Create a series of bookings and assign them to test round-robin cyclic behavior
$bookings = [];
for ($i = 1; $i <= 5; $i++) {
    $booking = Booking::create([
        'client_name' => "Client $i",
        'client_phone' => "1234567$i",
        'car_id' => $car->id,
        'total_price' => 100000,
        'down_payment' => 20000,
        'duration_years' => 5,
        'monthly_installment' => 1500,
        'status' => 'new',
        'source' => 'website',
    ]);
    $bookings[] = $booking;
}

echo "\n--- Performing Auto Assignment ---\n";
$service = new BookingAssignmentService;

foreach ($bookings as $idx => $booking) {
    $service->autoAssign($booking);
    $booking->refresh();
    $assignedRepName = $booking->employee ? $booking->employee->name : 'NONE';
    $assignedRepRole = $booking->employee ? $booking->employee->role : 'NONE';
    echo "Booking '{$booking->client_name}' assigned to Employee ID: {$booking->assigned_to} ($assignedRepName - Role: $assignedRepRole)\n";
}

// Cleanup bookings and temporary rep
foreach ($bookings as $booking) {
    $booking->delete();
}
if ($testRep) {
    $testRep->delete();
}

// Revert auto_assign setting
if ($prevAutoAssign) {
    Setting::updateOrCreate(['key' => 'auto_assign_bookings'], ['value' => $prevAutoAssign->value]);
} else {
    Setting::where('key', 'auto_assign_bookings')->delete();
}

echo "\nVerification script completed successfully.\n";
