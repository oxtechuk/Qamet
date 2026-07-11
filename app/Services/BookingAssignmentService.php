<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Employee;
use App\Models\Setting;
use App\Notifications\NewBookingNotification;

class BookingAssignmentService
{
    /**
     * Automatically assigns a booking to a sales representative using Round-Robin.
     *
     * @param Booking $booking
     * @return void
     */
    public function autoAssign(Booking $booking)
    {
        // 1. Check if auto assignment is enabled in settings
        $settings = Setting::all()->pluck('value', 'key');
        $isEnabled = isset($settings['auto_assign_bookings']) && $settings['auto_assign_bookings'] == '1';

        if (!$isEnabled) {
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

        // 3. Find the last assigned booking to a sales rep
        $lastBooking = Booking::whereNotNull('assigned_to')
            ->whereHas('employee', function ($q) {
                $q->whereIn('role', ['sales', 'sales-rep']);
            })
            ->latest('id')
            ->first();

        $assignedRep = null;

        if ($lastBooking) {
            // Find the index of the last assigned employee
            $lastIndex = $salesReps->search(fn($rep) => $rep->id == $lastBooking->assigned_to);

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
                __('تم تعيين طلب جديد لك للعميل') . ' ' . $booking->client_name
            ));
        }
    }
}
