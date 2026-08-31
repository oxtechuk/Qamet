<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\Setting;
use App\Notifications\NewBookingNotification;
use App\Notifications\NewLeadNotification;

class BookingAssignmentService
{
    /**
     * Automatically assigns a booking to a sales representative using Round-Robin.
     *
     * @return void
     */
    /**
     * Automatically assigns a booking to a sales representative using Round-Robin.
     *
     * @return void
     */
    public function autoAssign(Booking $booking)
    {
        // 1. Check if auto assignment is enabled in settings
        $settings = Setting::all()->pluck('value', 'key');
        $isEnabled = isset($settings['auto_assign_bookings']) && $settings['auto_assign_bookings'] == '1';

        if (! $isEnabled) {
            return;
        }

        // 2. Fetch active employees strictly based on required booking permissions
        $salesReps = $this->getEligibleEmployeesForBooking($booking);

        if ($salesReps->isEmpty()) {
            return;
        }

        // 3. Find the last assigned representative across bookings for this specialization
        $lastAssignedRepId = $this->getLastAssignedRepIdForPaymentMethod($booking->payment_method);

        $assignedRep = null;

        if ($lastAssignedRepId !== null) {
            $lastIndex = $salesReps->search(fn ($rep) => $rep->id == $lastAssignedRepId);

            if ($lastIndex !== false && $lastIndex < $salesReps->count() - 1) {
                $assignedRep = $salesReps[$lastIndex + 1];
            } else {
                $assignedRep = $salesReps->first();
            }
        } else {
            $assignedRep = $salesReps->first();
        }

        // 4. Assign the booking to the selected representative
        if ($assignedRep) {
            $booking->update([
                'assigned_to' => $assignedRep->id,
            ]);

            // 5. Notify the assigned representative
            $assignedRep->notify(new NewBookingNotification(
                $booking,
                __('طلب جديد'),
                __('تم تعيين طلب جديد لك للعميل').' '.$booking->client_name
            ));
        }
    }

    /**
     * Get active sales representatives eligible for a given booking.
     */
    public function getEligibleEmployeesForBooking(Booking $booking)
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
     * Finds the most recently assigned sales representative's ID for a given payment method.
     */
    private function getLastAssignedRepIdForPaymentMethod(?string $paymentMethod): ?int
    {
        $query = Booking::whereNotNull('assigned_to');

        if ($paymentMethod === 'cash') {
            $query->where('payment_method', 'cash');
        } else {
            $query->where('payment_method', '!=', 'cash');
        }

        $lastBooking = $query->latest('id')->first();

        return $lastBooking ? (int) $lastBooking->assigned_to : $this->getLastAssignedRepId();
    }

    /**
     * Automatically assigns a general lead to a sales representative using Round-Robin.
     *
     * @return void
     */
    public function autoAssignLead(Lead $lead)
    {
        // 1. Check if auto assignment is enabled in settings
        $settings = Setting::all()->pluck('value', 'key');
        $isEnabled = isset($settings['auto_assign_bookings']) && $settings['auto_assign_bookings'] == '1';

        if (! $isEnabled) {
            return;
        }

        // 2. Fetch active sales representatives with lead/booking permissions
        $salesReps = $this->getEligibleEmployeesForLead($lead);

        if ($salesReps->isEmpty()) {
            return;
        }

        // 3. Find the last assigned representative across both Booking and Lead models
        $lastAssignedRepId = $this->getLastAssignedRepId();

        $assignedRep = null;

        if ($lastAssignedRepId !== null) {
            $lastIndex = $salesReps->search(fn ($rep) => $rep->id == $lastAssignedRepId);

            if ($lastIndex !== false && $lastIndex < $salesReps->count() - 1) {
                $assignedRep = $salesReps[$lastIndex + 1];
            } else {
                $assignedRep = $salesReps->first();
            }
        } else {
            $assignedRep = $salesReps->first();
        }

        // 4. Assign the lead to the selected representative
        if ($assignedRep) {
            $lead->update([
                'assigned_to' => $assignedRep->id,
            ]);

            // 5. Notify the assigned representative
            $assignedRep->notify(new NewLeadNotification(
                $lead,
                __('عميل جديد'),
                __('تم تعيين عميل جديد لك:').' '.$lead->client_name
            ));
        }
    }

    /**
     * Get active sales representatives eligible for leads.
     */
    public function getEligibleEmployeesForLead(Lead $lead)
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
     * Finds the most recently assigned sales representative's ID across both Booking and Lead models.
     */
    private function getLastAssignedRepId(): ?int
    {
        $lastBooking = Booking::whereNotNull('assigned_to')
            ->latest('id')
            ->first();

        $lastLead = Lead::whereNotNull('assigned_to')
            ->latest('id')
            ->first();

        if ($lastBooking && $lastLead) {
            return $lastBooking->created_at->gt($lastLead->created_at)
                ? (int) $lastBooking->assigned_to
                : (int) $lastLead->assigned_to;
        }

        if ($lastBooking) {
            return (int) $lastBooking->assigned_to;
        }

        if ($lastLead) {
            return (int) $lastLead->assigned_to;
        }

        return null;
    }
}
