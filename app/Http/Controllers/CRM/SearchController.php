<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Employee;
use App\Models\Lead;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $query = $request->get('query');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $results = [];

        // 1. Search Customers (Leads)
        $leads = Lead::where('client_name', 'LIKE', "%{$query}%")
            ->orWhere('client_phone', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();

        foreach ($leads as $lead) {
            $results[] = [
                'type' => 'customer',
                'category' => __('عميل'),
                'title' => $lead->client_name,
                'subtitle' => $lead->client_phone,
                'link' => route('crm.leads.edit', $lead->id),
                'icon' => 'bi-person-badge',
            ];
        }

        // 2. Search Bookings (Orders)
        $bookings = Booking::where('client_name', 'LIKE', "%{$query}%")
            ->orWhere('id', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();

        foreach ($bookings as $booking) {
            $results[] = [
                'type' => 'booking',
                'category' => __('طلب حجز'),
                'title' => "#{$booking->id} - {$booking->client_name}",
                'subtitle' => $booking->car->name ?? '',
                'link' => route('crm.bookings.show', $booking->id),
                'icon' => 'bi-cart-check',
            ];
        }

        // 3. Search Employees (Staff)
        $employees = Employee::where('name', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();

        foreach ($employees as $employee) {
            $results[] = [
                'type' => 'employee',
                'category' => __('موظف مبيعات'),
                'title' => $employee->name,
                'subtitle' => $employee->email,
                'link' => '#', // No direct edit link for staff sometimes, but could link to their report
                'icon' => 'bi-person-workspace',
            ];
        }

        return response()->json($results);
    }
}
