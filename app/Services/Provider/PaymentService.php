<?php

namespace App\Services\Provider;

use App\Models\Provider;
use App\Repositories\Provider\PaymentRepositry as ProviderPaymentRepositry;

class PaymentService
{
    protected $paymentRepo;

    public function __construct(ProviderPaymentRepositry $paymentRepo)
    {
        $this->paymentRepo = $paymentRepo;
    }

    public function getAllPayments(Provider $provider, $status = null, $search = null)
    {
        return $this->paymentRepo->getAllPayments($provider, $status, $search);
    }

   
}
