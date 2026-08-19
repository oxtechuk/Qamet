<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Employee;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = \Illuminate\Support\Facades\Cache::remember('crm_dashboard_stats', 300, function () {
            return [
                'total' => Booking::count(),
                'new' => Booking::new()->count(),
                'in_progress' => Booking::inProgress()->count(),
                'sold' => Booking::completed()->count(),
                'rejected' => Booking::where('status', 'rejected')->count(),
            ];
        });

        // أكثر 5 سيارات عليها طلبات
        $topCars = \Illuminate\Support\Facades\Cache::remember('crm_dashboard_top_cars', 300, function () {
            return Car::withCount('bookings')
                ->with('brand') // Eager load brand for grid
                ->orderByDesc('bookings_count')
                ->limit(6) // increased to 6 for a better grid
                ->get();
        });

        // إحصائيات الأسبوع (آخر 7 أيام) للـ Chart
        $weeklyBookings = \Illuminate\Support\Facades\Cache::remember('crm_dashboard_weekly_bookings', 300, function () {
            return Booking::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays(6))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        });

        $recentBookings = Booking::with('car.brand')
            ->latest()
            ->limit(10)
            ->get();

        $totals = \Illuminate\Support\Facades\Cache::remember('crm_dashboard_totals', 300, function () {
            return [
                'cars' => Car::where('is_active', true)->count(),
                'brands' => Brand::count(),
                'employees' => Employee::count(),
            ];
        });

        $totalCars = $totals['cars'];
        $totalBrands = $totals['brands'];
        $totalEmployees = $totals['employees'];

        $trackingGA = Setting::where('key', 'google_analytics_id')->first()?->value ?? '';
        $trackingPixel = Setting::where('key', 'meta_pixel_id')->first()?->value ?? '';

        return view('crm.dashboard', compact(
            'stats', 'topCars', 'weeklyBookings', 'recentBookings',
            'totalCars', 'totalBrands', 'totalEmployees',
            'trackingGA', 'trackingPixel'
        ));
    }
}
