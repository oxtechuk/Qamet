<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\Setting;
use App\Notifications\NewBookingNotification;
use App\Notifications\NewLeadNotification;
use Illuminate\Support\Collection;

class BookingAssignmentService
{
    /**
     * Automatically assigns a booking to a sales representative using Fair Workload Balancing (Least-Loaded).
     *
     * @return Employee|null
     */
    public function autoAssign(Booking $booking): ?Employee
    {
        // 1. Check if auto assignment is enabled in settings
        $settings = Setting::all()->pluck('value', 'key');
        $isEnabled = isset($settings['auto_assign_bookings']) && (string) $settings['auto_assign_bookings'] === '1';

        if (! $isEnabled) {
            return null;
        }

        // 2. Fetch active employees strictly based on required booking permissions and specialization
        $salesReps = $this->getEligibleEmployeesForBooking($booking);

        if ($salesReps->isEmpty()) {
            return null;
        }

        // 3. Find the least-loaded representative (fairest distribution)
        $assignedRep = $this->findLeastLoadedRepForBooking($salesReps, $booking);

        // 4. Assign the booking to the selected representative
        if ($assignedRep) {
            $booking->update([
                'assigned_to' => $assignedRep->id,
            ]);

            // 5. Notify the assigned representative
            try {
                $assignedRep->notify(new NewBookingNotification(
                    $booking,
                    __('طلب جديد'),
                    __('تم تعيين طلب جديد لك للعميل').' '.$booking->client_name
                ));
            } catch (\Throwable $e) {
                // Ignore notification failure
            }

            return $assignedRep;
        }

        return null;
    }

    /**
     * Find the least-loaded representative from eligible reps for a specific booking.
     */
    public function findLeastLoadedRepForBooking(Collection $salesReps, Booking $booking, array $extraCounts = []): ?Employee
    {
        if ($salesReps->isEmpty()) {
            return null;
        }

        $isCash = $booking->payment_method === 'cash';
        $isCorporate = $booking->booking_type === 'corporate';
        $repIds = $salesReps->pluck('id')->toArray();

        // Count assigned active/open bookings per rep for this specialization
        $query = Booking::query()
            ->whereIn('assigned_to', $repIds)
            ->whereNotIn('status', ['cancelled', 'rejected']);

        if ($isCash) {
            $query->where('payment_method', 'cash');
        } elseif ($isCorporate) {
            $query->where('booking_type', 'corporate');
        } else {
            $query->where('payment_method', '!=', 'cash')->where('booking_type', '!=', 'corporate');
        }

        $counts = $query->selectRaw('assigned_to, count(*) as total')
            ->groupBy('assigned_to')
            ->pluck('total', 'assigned_to')
            ->toArray();

        // Get latest assignment timestamp for tie-breaker (least recently assigned)
        $lastAssigned = Booking::whereIn('assigned_to', $repIds)
            ->selectRaw('assigned_to, max(created_at) as last_time')
            ->groupBy('assigned_to')
            ->pluck('last_time', 'assigned_to')
            ->toArray();

        // Sort reps by: 1. Total workload ascending, 2. Last assigned ascending (LRU), 3. ID ascending
        return $salesReps->sortBy(function (Employee $rep) use ($counts, $extraCounts, $lastAssigned) {
            $repId = $rep->id;
            $workload = ($counts[$repId] ?? 0) + ($extraCounts[$repId] ?? 0);
            $lastTime = isset($lastAssigned[$repId]) ? strtotime($lastAssigned[$repId]) : 0;

            return sprintf('%08d_%012d_%06d', $workload, $lastTime, $repId);
        })->first();
    }

    /**
     * Get active sales representatives eligible for a given booking.
     */
    public function getEligibleEmployeesForBooking(Booking $booking): Collection
    {
        $isCash = $booking->payment_method === 'cash';
        $isCorporate = $booking->booking_type === 'corporate';

        return Employee::where('is_active', true)
            ->orderBy('id')
            ->get()
            ->filter(function (Employee $employee) use ($isCash, $isCorporate) {
                // 1. Exclude Admin, Manager, and Data Entry
                if ($employee->isAdmin() || in_array($employee->role, ['admin', 'manager', 'data_entry'])) {
                    return false;
                }

                if ($employee->hasAnyRole(['admin', 'Super Admin', 'manager', 'data_entry', 'Data Entry', 'مدير', 'مدخل بيانات'], 'employee')) {
                    return false;
                }

                // 2. Must have sales_type set (not empty or none)
                if (empty($employee->sales_type) || $employee->sales_type === 'none') {
                    return false;
                }

                // 3. Must match payment method / booking type:
                if ($isCash) {
                    if (! in_array($employee->sales_type, ['cash', 'all'])) {
                        return false;
                    }
                    if (! $employee->hasPermission(['manage-cash-bookings', 'manage-bookings'])) {
                        return false;
                    }
                } elseif ($isCorporate) {
                    if (! in_array($employee->sales_type, ['corporate', 'finance', 'all'])) {
                        return false;
                    }
                    if (! $employee->hasPermission(['manage-corporate-bookings', 'manage-finance-bookings', 'manage-bookings'])) {
                        return false;
                    }
                } else {
                    if (! in_array($employee->sales_type, ['finance', 'all'])) {
                        return false;
                    }
                    if (! $employee->hasPermission(['manage-finance-bookings', 'manage-bookings'])) {
                        return false;
                    }
                }

                return true;
            })
            ->values();
    }

    /**
     * Redistributes a given collection of bookings fairly and evenly among eligible sales representatives.
     *
     * @param iterable<Booking> $bookings
     * @return array{total: int, assigned: int, unassigned: int, reps_summary: array<string, int>}
     */
    public function redistributeBookings(iterable $bookings): array
    {
        $total = 0;
        $assigned = 0;
        $unassigned = 0;
        $repsSummary = [];
        $extraCounts = [];

        foreach ($bookings as $booking) {
            $total++;
            $salesReps = $this->getEligibleEmployeesForBooking($booking);

            if ($salesReps->isEmpty()) {
                $unassigned++;
                continue;
            }

            $selectedRep = $this->findLeastLoadedRepForBooking($salesReps, $booking, $extraCounts);

            if ($selectedRep) {
                $booking->update([
                    'assigned_to' => $selectedRep->id,
                ]);

                $extraCounts[$selectedRep->id] = ($extraCounts[$selectedRep->id] ?? 0) + 1;
                $repsSummary[$selectedRep->name] = ($repsSummary[$selectedRep->name] ?? 0) + 1;
                $assigned++;
            } else {
                $unassigned++;
            }
        }

        return [
            'total' => $total,
            'assigned' => $assigned,
            'unassigned' => $unassigned,
            'reps_summary' => $repsSummary,
        ];
    }

    /**
     * Performs a global or filtered rebalance across bookings according to specified criteria.
     *
     * @param array{scope?: string, type?: string, date_from?: ?string, date_until?: ?string} $options
     * @return array{total: int, assigned: int, unassigned: int, reps_summary: array<string, int>}
     */
    public function rebalanceAll(array $options = []): array
    {
        $scope = $options['scope'] ?? 'open';
        $type = $options['type'] ?? 'all';
        $dateFrom = $options['date_from'] ?? null;
        $dateUntil = $options['date_until'] ?? null;

        $query = Booking::query();

        // Apply Scope
        if ($scope === 'open') {
            $query->whereNotIn('status', ['closed', 'completed', 'cancelled', 'rejected']);
        } elseif ($scope === 'unassigned') {
            $query->whereNull('assigned_to');
        }

        // Apply Type Filter
        if ($type === 'cash') {
            $query->where('payment_method', 'cash');
        } elseif ($type === 'finance') {
            $query->where('payment_method', '!=', 'cash')->where('booking_type', '!=', 'corporate');
        } elseif ($type === 'corporate') {
            $query->where('booking_type', 'corporate');
        }

        // Apply Date Range
        if (! empty($dateFrom)) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if (! empty($dateUntil)) {
            $query->whereDate('created_at', '<=', $dateUntil);
        }

        $bookings = $query->orderBy('created_at', 'asc')->get();

        return $this->redistributeBookings($bookings);
    }

    /**
     * Automatically assigns a general lead to a sales representative using Least-Loaded Fair Balancing.
     *
     * @return Employee|null
     */
    public function autoAssignLead(Lead $lead): ?Employee
    {
        $settings = Setting::all()->pluck('value', 'key');
        $isEnabled = isset($settings['auto_assign_bookings']) && (string) $settings['auto_assign_bookings'] === '1';

        if (! $isEnabled) {
            return null;
        }

        $salesReps = $this->getEligibleEmployeesForLead($lead);

        if ($salesReps->isEmpty()) {
            return null;
        }

        $assignedRep = $this->findLeastLoadedRepForLead($salesReps);

        if ($assignedRep) {
            $lead->update([
                'assigned_to' => $assignedRep->id,
            ]);

            try {
                $assignedRep->notify(new NewLeadNotification(
                    $lead,
                    __('عميل جديد'),
                    __('تم تعيين عميل جديد لك:').' '.$lead->client_name
                ));
            } catch (\Throwable $e) {
                // Ignore notification failure
            }

            return $assignedRep;
        }

        return null;
    }

    /**
     * Find least loaded rep for leads.
     */
    public function findLeastLoadedRepForLead(Collection $salesReps, array $extraCounts = []): ?Employee
    {
        if ($salesReps->isEmpty()) {
            return null;
        }

        $repIds = $salesReps->pluck('id')->toArray();

        $counts = Lead::query()
            ->whereIn('assigned_to', $repIds)
            ->whereNotIn('status', ['cancelled', 'lost', 'rejected'])
            ->selectRaw('assigned_to, count(*) as total')
            ->groupBy('assigned_to')
            ->pluck('total', 'assigned_to')
            ->toArray();

        $lastAssigned = Lead::whereIn('assigned_to', $repIds)
            ->selectRaw('assigned_to, max(created_at) as last_time')
            ->groupBy('assigned_to')
            ->pluck('last_time', 'assigned_to')
            ->toArray();

        return $salesReps->sortBy(function (Employee $rep) use ($counts, $extraCounts, $lastAssigned) {
            $repId = $rep->id;
            $workload = ($counts[$repId] ?? 0) + ($extraCounts[$repId] ?? 0);
            $lastTime = isset($lastAssigned[$repId]) ? strtotime($lastAssigned[$repId]) : 0;

            return sprintf('%08d_%012d_%06d', $workload, $lastTime, $repId);
        })->first();
    }

    /**
     * Get active sales representatives eligible for leads.
     */
    public function getEligibleEmployeesForLead(Lead $lead): Collection
    {
        return Employee::where('is_active', true)
            ->orderBy('id')
            ->get()
            ->filter(function (Employee $employee) {
                if ($employee->isAdmin() || in_array($employee->role, ['admin', 'manager', 'data_entry'])) {
                    return false;
                }

                if ($employee->hasAnyRole(['admin', 'Super Admin', 'manager', 'data_entry', 'Data Entry', 'مدير', 'مدخل بيانات'], 'employee')) {
                    return false;
                }

                if (empty($employee->sales_type) || $employee->sales_type === 'none') {
                    return false;
                }

                return $employee->hasPermission(['manage-leads', 'manage-bookings', 'manage-cash-bookings', 'manage-finance-bookings']);
            })
            ->values();
    }

    /**
     * Redistributes a given collection of leads fairly and evenly.
     */
    public function redistributeLeads(iterable $leads): array
    {
        $total = 0;
        $assigned = 0;
        $unassigned = 0;
        $repsSummary = [];
        $extraCounts = [];

        foreach ($leads as $lead) {
            $total++;
            $salesReps = $this->getEligibleEmployeesForLead($lead);

            if ($salesReps->isEmpty()) {
                $unassigned++;
                continue;
            }

            $selectedRep = $this->findLeastLoadedRepForLead($salesReps, $extraCounts);

            if ($selectedRep) {
                $lead->update([
                    'assigned_to' => $selectedRep->id,
                ]);

                $extraCounts[$selectedRep->id] = ($extraCounts[$selectedRep->id] ?? 0) + 1;
                $repsSummary[$selectedRep->name] = ($repsSummary[$selectedRep->name] ?? 0) + 1;
                $assigned++;
            } else {
                $unassigned++;
            }
        }

        return [
            'total' => $total,
            'assigned' => $assigned,
            'unassigned' => $unassigned,
            'reps_summary' => $repsSummary,
        ];
    }
}

