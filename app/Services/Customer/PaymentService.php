<?php

namespace App\Services\Customer;

use App\Models\Customer;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\PaymentSchedule;
use App\Models\PaymentTransaction;
use App\Repositories\Customer\ContractRepository;
use App\Repositories\Customer\PaymentRepositry;
use App\Utils\OfferUtility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $paymentRepo;

    public function __construct(PaymentRepositry $paymentRepo)
    {
        $this->paymentRepo = $paymentRepo;
    }

    public function create(array $data)
    {
        return $this->paymentRepo->store($data);
    }

    public function getAllPayments(Customer $customer, $status = null, $search = null)
    {
        return $this->paymentRepo->getAllPayments($customer, $status, $search);
    }

    public function handleDepositPayment($data)
    {
        // Handle deposit payment logic
        Log::info('Handling deposit payment', $data);
        DB::beginTransaction();

        try {
            $offer = Offer::findOrFail($data['offer_id']);
            $contractTotalWithTax = OfferUtility::getDetails($offer)['total_amount_with_tax'];

            $contractData =
                ['offer_id' => $offer->id,
                    'deposit' => $data['amount'],
                    'remaining' => $contractTotalWithTax - $data['amount'],
                    'tax_percentage' => getTaxPercentage($offer),
                    'deposit_paid' => 1,
                    'mobile_verification' => 1234,  // 4-digit code (more realistic)],
                    'reference' => uniqid('CNT_')  // Example: ref_64e03cd8f1e55
                ];

            $contractService = new ContractService(new ContractRepository());
            $contract = $contractService->create($contractData);

            $depositeRecord = $offer->deposite();
            $depositeRecord->update(['status' => 'paid']);

            $paymentData = [
                'amount' => $data['amount'],
                'sender_id' => $data['sender_id'],
                'payment_schedule_id' => $offer->deposite()->id,
                'contract_id' => $contract->id,
                'status' => 'hold',
                'transaction_reference' => $data['transaction_reference'],
                'provider_id' => $offer->provider->id,
            ];

            $payment = $this->create($paymentData);
            Log::info('Deposit payment created', ['payment_id' => $payment->id]);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error handling deposit payment: ' . $e->getMessage());
            // You can log the error or return a proper error response
            return false;
        }
    }

      public function processDepositPayment($data)
    {
        DB::beginTransaction();

        try {
            // 🔐 Idempotency
            if ($this->transactionExists($data['transaction_reference'])) {
                DB::rollBack();
                return true;
            }

            $offer = Offer::findOrFail($data['offer_id']);
            $contractTotalWithTax = OfferUtility::getDetails($offer)['total_amount_with_tax'];

            $contractService = new ContractService(new ContractRepository());

            $contract = $contractService->create([
                'offer_id' => $offer->id,
                'deposit' => $data['amount'],
                'remaining' => $contractTotalWithTax - $data['amount'],
                'tax_percentage' => getTaxPercentage($offer),
                'deposit_paid' => 1,
                'mobile_verification' => 1234,
                'reference' => uniqid('CNT_'),
            ]);

            $offer->deposite()->update(['status' => 'paid']);


              $paymentData = [
                'amount' => $data['amount'],
                'sender_id' => $data['sender_id'],
                'payment_schedule_id' => $offer->deposite()->id,
                'contract_id' => $contract->id,
                'status' => 'hold',
                'transaction_reference' => $data['transaction_reference'],
                'provider_id' => $offer->provider->id,
            ];


            $payment = $this->create($paymentData);
            DB::commit();
            return true;

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Deposit payment failed', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return false;
        }
    }

    // public function handleStagePayments($data)
    // {
    //     if ($data['stage_type'] == 'deposite') {
    //         // Handle deposite payment logic

    //         $handle = $this->handleDepositPayment($data);

    //         if ($handle) {
    //             return redirect()->route('customer.contract.sign', $data['offer_id'])->with('success', 'Deposite payment successful');
    //         } else
    //             return redirect()->route('customer.contract.sign', $data['offer_id'])->with('error', 'Deposite payment failed');
    //     } elseif ($data['stage_type'] == 'stage') {
    //         $offerService = app()->make(OfferService::class);
    //         return $offerService->acceptStagePayment($data['stage_id'], $data['transaction_reference']);
    //     }
    // }

     public function handleStagePayments(array $data)
    {
        if ($data['stage_type'] === 'deposite') {

            $success = $this->processDepositPayment($data);

            return redirect()
                ->route('customer.contract.sign', $data['offer_id'])
                ->with(
                    $success ? 'success' : 'error',
                    $success ? 'Deposit payment successful' : 'Deposit payment failed'
                );
        }

        if ($data['stage_type'] === 'stage') {

          
                $offerService = app()->make(OfferService::class);
                $offerService->acceptStagePayment(
                $data['stage_id'],
                $data['transaction_reference']
                );

            $projectId = OfferItem::find($data['stage_id'])
                ->offer
                ->project_id;

            return redirect()
                ->route('customer.project.implementation.index', $projectId)
                ->with('success', 'Payment completed successfully');
        }
    }

     private function transactionExists(string $reference): bool
    {
        return PaymentTransaction::where(
            'transaction_reference',
            $reference
        )->exists();
    }
}
