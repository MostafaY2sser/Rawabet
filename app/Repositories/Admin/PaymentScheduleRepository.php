<?php

namespace App\Repositories\Admin;

use App\Models\PaymentSchedule;

class PaymentScheduleRepository
{
    public function getByOfferId($offerId)
    {
        return PaymentSchedule::where('offer_id', $offerId)->get();
    }

    public function updateSchedules($offerId, $schedules)
    {
       
        PaymentSchedule::where('offer_id', $offerId)->delete();

     
        foreach ($schedules as $schedule) {
            PaymentSchedule::create([
                'offer_id'   => $offerId,
                'percentage' => $schedule['percentage'],
                'amount'     => $schedule['amount'],
                'due_date'   => $schedule['due_date'] ?? null,
            ]);
        }
    }
}
