<?php

namespace App\Services\Admin;

use App\Repositories\Admin\PaymentScheduleRepository;

class PaymentScheduleService
{
    protected $paymentScheduleRepository;

    public function __construct(PaymentScheduleRepository $paymentScheduleRepository)
    {
        $this->paymentScheduleRepository = $paymentScheduleRepository;
    }

    public function getByOfferId($offerId)
    {
        return $this->paymentScheduleRepository->getByOfferId($offerId);
    }

    public function updateSchedules($offerId, $schedules)
    {
        return $this->paymentScheduleRepository->updateSchedules($offerId, $schedules);
    }
}
