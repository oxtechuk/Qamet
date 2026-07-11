<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class TrackingController extends Controller
{
    public function index()
    {
        $columns = [
            'new'        => ['label' => 'جديد',        'color' => '#1877F2', 'count' => 0],
            'contacted'  => ['label' => 'تم التواصل',    'color' => '#0DCAF0', 'count' => 0],
            'interested' => ['label' => 'مهتم',         'color' => '#FF9800', 'count' => 0],
            'rejected'   => ['label' => 'مرفوض',        'color' => '#EE1E26', 'count' => 0],
            'sold'       => ['label' => 'تم البيع ✓',   'color' => '#4CAF50', 'count' => 0],
        ];

        $bookings = Booking::with(['car.brand', 'assignedTo'])->withCount('notes_list')
            ->latest()
            ->get()
            ->groupBy(function ($b) {
                return array_key_exists($b->status, Booking::STATUSES) ? $b->status : 'new';
            });

        foreach ($columns as $key => &$col) {
            $col['items'] = $bookings[$key] ?? collect();
            $col['count'] = $col['items']->count();
        }

        return view('crm.tracking.index', compact('columns'));
    }
}
