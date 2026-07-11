<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactSource;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function bookings(Request $request)
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        $from = $request->input('from', now()->subMonth()->toDateString());
        $to = $request->input('to', now()->toDateString());

        $base = Booking::query()
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);

        // 1. Financial Performance
        $financial = [
            'total_sold' => (clone $base)->where('status', 'sold')->count(),
            'total_down_payment' => (clone $base)->where('status', 'sold')->sum('down_payment'),
            'total_remaining' => (clone $base)->where('status', 'sold')
                ->selectRaw('SUM(monthly_installment * (duration_years * 12)) as total')->value('total') ?? 0,
            'total_bookings' => (clone $base)->count()
        ];

        // 2. Employee Performance
        $employees = (clone $base)->whereNotNull('assigned_to')
            ->selectRaw('assigned_to, count(*) as total_bookings, sum(case when status = \'sold\' then 1 else 0 end) as total_sold')
            ->groupBy('assigned_to')
            ->with('employee:id,name')
            ->get();

        // 3. Car Popularity
        $topCars = (clone $base)->whereNotNull('car_id')
            ->selectRaw('car_id, count(*) as total_bookings, sum(case when status = \'sold\' then 1 else 0 end) as total_sold')
            ->groupBy('car_id')
            ->orderByDesc('total_bookings')
            ->take(5)
            ->with('car.brand')
            ->get();

        // 4. Installments Analysis (For sold or interested)
        $installments = [
            'avg_down_payment' => (clone $base)->where('down_payment', '>', 0)->avg('down_payment') ?? 0,
            'avg_duration' => (clone $base)->where('duration_years', '>', 0)->avg('duration_years') ?? 0,
            'avg_monthly' => (clone $base)->where('monthly_installment', '>', 0)->avg('monthly_installment') ?? 0,
        ];

        // 5. Sources Analysis
        $sourcesReport = (clone $base)->whereNotNull('source')
            ->selectRaw('source, count(*) as total_bookings, sum(case when status = \'sold\' then 1 else 0 end) as total_sold, sum(case when status = \'rejected\' then 1 else 0 end) as total_rejected')
            ->groupBy('source')
            ->orderByDesc('total_bookings')
            ->get();

        return view('crm.reports.bookings', compact(
            'from', 'to', 'financial', 'employees', 'topCars', 'installments', 'sourcesReport', 'settings'
        ));
    }

    /** تقرير مصادر التواصل (عملاء محتملون + طلبات الموقع) */
    public function sources()
    {
        $leadBySource = Lead::query()
            ->selectRaw('contact_source_id, count(*) as total')
            ->groupBy('contact_source_id')
            ->pluck('total', 'contact_source_id');

        $contactSources = ContactSource::orderBy('sort_order')->orderBy('id')->get();

        $bookingBySource = Booking::query()
            ->selectRaw('source, count(*) as total')
            ->groupBy('source')
            ->pluck('total', 'source');

        $leadsTotal = Lead::count();
        $bookingsTotal = Booking::count();

        return view('crm.reports.sources', compact(
            'leadBySource',
            'contactSources',
            'bookingBySource',
            'leadsTotal',
            'bookingsTotal'
        ));
    }

    /** تقرير شهري: نشاط الطلبات والعملاء المحتملين */
    public function monthly()
    {
        $start = now()->subMonths(11)->startOfMonth();

        $bookingRows = Booking::query()
            ->where('created_at', '>=', $start)
            ->get(['created_at']);

        $leadRows = Lead::query()
            ->where('created_at', '>=', $start)
            ->get(['created_at']);

        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $m = now()->copy()->subMonths($i)->startOfMonth();
            $key = $m->format('Y-m');
            $months[$key] = [
                'label'    => $m->translatedFormat('M Y'),
                'bookings' => 0,
                'leads'    => 0,
            ];
        }

        foreach ($bookingRows as $b) {
            $key = Carbon::parse($b->created_at)->format('Y-m');
            if (isset($months[$key])) {
                $months[$key]['bookings']++;
            }
        }
        foreach ($leadRows as $l) {
            $key = Carbon::parse($l->created_at)->format('Y-m');
            if (isset($months[$key])) {
                $months[$key]['leads']++;
            }
        }

        return view('crm.reports.monthly', compact('months'));
    }
}
