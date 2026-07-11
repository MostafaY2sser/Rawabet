<?php
namespace App\Repositories\Customer;

use App\Enums\PaymentStatus;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\PaymentTransaction;
use App\Models\Provider;
use App\Services\Customer\ContractService;
use Illuminate\Support\Facades\DB;

class PaymentRepositry
{
    public function store($data)
    {

        $provider = Provider::find($data['provider_id']);

        $customer = Customer::find($data['sender_id']);


        $transaction = new PaymentTransaction([
            'amount' => $data['amount'],
            'contract_id' => $data['contract_id'],
            'status' => $data['status'],
            'transaction_reference' => $data['transaction_reference'],
            'sender_id' => $data['sender_id'],
            'payment_schedule_id' => $data['payment_schedule_id']
        ]);

        $transaction->sender()->associate($customer);

        $transaction->beneficiary()->associate($provider);
        $transaction->save();
        return $transaction;
    }

   

    public function getAllPayments(Customer $customer, $status = null, $search = null)
    {
        $query = $customer->payments()->with(['payementStage', 'contract.offer.project']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_reference', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        $payments = $query->paginate(10)->withQueryString();
        $totalProfits = $customer->payments()->where('status', PaymentStatus::COMPLETED->value)->sum('amount');

        $pendings = $customer->payments()->where('status', PaymentStatus::PENDING->value);
        $processings = $customer->payments()->where('status', PaymentStatus::HOLD->value);

        $pendingPayments = $pendings->sum('amount');
        $processingPayments = $processings->sum('amount');

        $averagePayment = $payments->avg('amount');

        $totalCount = $customer->payments()->count();  // use paginator's total()
        $completedCount = $payments->where('status', PaymentStatus::COMPLETED->value)->count();
        $pendingCount = $pendings->count();
        $processingCount = $processings->count();
        $failedCount = $payments->where('status', PaymentStatus::FAILED->value)->count();

        return [
            'totalProfits' => $totalProfits,
            'pendingPayments' => $pendingPayments,
            'processingPayments' => $processingPayments,
            'averagePayment' => $averagePayment,
            'payments' => $payments,  // this is paginated
            'totalCount' => $totalCount,
            'completedCount' => $completedCount,
            'pendingCount' => $pendingCount,
            'processingCount' => $processingCount,
            'failedCount' => $failedCount,
        ];
    }
}

?>