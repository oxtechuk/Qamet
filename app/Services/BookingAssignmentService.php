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
    public function autoAssign(Booking $booking)
    {
        // 1. Check if auto assignment is enabled in settings
        $settings = Setting::all()->pluck('value', 'key');
        $isEnabled = isset($settings['auto_assign_bookings']) && $settings['auto_assign_bookings'] == '1';

        if (! $isEnabled) {
            return;
        }

        // 2. Fetch all active sales representatives
        $salesReps = Employee::whereIn('role', ['sales', 'sales-rep'])
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        if ($salesReps->isEmpty()) {
            return;
        }

        // 3. Find the last assigned representative across both Booking and Lead models
        $lastAssignedRepId = $this->getLastAssignedRepId();

        $assignedRep = null;

        if ($lastAssignedRepId !== null) {
            // Find the index of the last assigned employee
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

        // 2. Fetch all active sales representatives
        $salesReps = Employee::whereIn('role', ['sales', 'sales-rep'])
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        if ($salesReps->isEmpty()) {
            return;
        }

        // 3. Find the last assigned representative across both Booking and Lead models
        $lastAssignedRepId = $this->getLastAssignedRepId();

        $assignedRep = null;

        if ($lastAssignedRepId !== null) {
            // Find the index of the last assigned employee
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
     * Finds the most recently assigned sales representative's ID across both Booking and Lead models.
     */
    private function getLastAssignedRepId(): ?int
    {
        $lastBooking = Booking::whereNotNull('assigned_to')
            ->whereHas('employee', function ($q) {
                $q->whereIn('role', ['sales', 'sales-rep']);
            })
            ->latest('id')
            ->first();

        $lastLead = Lead::whereNotNull('assigned_to')
            ->whereHas('employee', function ($q) {
                $q->whereIn('role', ['sales', 'sales-rep']);
            })
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
