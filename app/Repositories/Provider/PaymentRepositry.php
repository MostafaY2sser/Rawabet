<?php
namespace App\Repositories\Provider;

use App\Enums\PaymentStatus;
use App\Models\PaymentTransaction;
use App\Models\Provider;

class PaymentRepositry
{
   public function getAllPayments(Provider $provider, $status = null, $search = null)
{
   $query = $provider->payments()->with(['payementStage', 'contract.offer.project']);

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


   
$totalProfits = $provider->payments()->where('status', PaymentStatus::COMPLETED->value)->sum('amount');

$pendings = $provider->payments()->where('status', PaymentStatus::PENDING->value);
$processings = $provider->payments()->where('status', PaymentStatus::HOLD->value);

$pendingPayments = $pendings->sum('amount');
$processingPayments = $processings->sum('amount');

$averagePayment = $payments->avg('amount');

$totalCount = $provider->payments()->count(); // use paginator's total()

$completedCount = $provider->payments()->where('status', PaymentStatus::COMPLETED->value)->count();
$pendingCount = $pendings->count();
$processingCount = $processings->count();
$failedCount = $payments->where('status', PaymentStatus::FAILED->value)->count();

return [
    'totalProfits' => $totalProfits,
    'pendingPayments' => $pendingPayments,
    'processingPayments' => $processingPayments,
    'averagePayment' => $averagePayment,
    'payments' => $payments, // this is paginated
    'totalCount' => $totalCount,
    'completedCount' => $completedCount,
    'pendingCount' => $pendingCount,
    'processingCount' => $processingCount,
    'failedCount' => $failedCount,
];

}

}

?>