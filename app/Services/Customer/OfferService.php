<?php

namespace App\Services\Customer;

use App\Enums\OfferItemStatus;
use App\Enums\OfferStatus;
use App\Enums\ProjectStatus;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\PaymentTransaction;
use App\Repositories\Customer\OfferRepository;

use function Laravel\Prompts\error;

class OfferService
{
  protected $offerRepo;

  public function __construct(OfferRepository $offerRepo)
  {
    $this->offerRepo = $offerRepo;
  }

  public function accept($data)
  {
    return $this->offerRepo->accept($data);
  }

  public function getSelectedAdditionServices($data, $offerId)
  {
    return $this->offerRepo->getSelectedAdditionServices($data, $offerId);
  }

  public function acceptStagePayment($id , $transactionReference)
  {
    $offerItem = OfferItem::find($id);

    $offerItem->status = OfferItemStatus::PAID;
    $offerItem->save();

    $project = $offerItem->offer->project;
    if ($offerItem->type == 'provider') {
      $offerItem->paymentSchedule()->update(['status' => 'paid']);
      // Check if this was the last unpaid item
      $remainingUnpaid = $offerItem
        ->offer
        ->items()
        ->where('status', '!=', OfferItemStatus::PAID)
        ->exists();

      if (!$remainingUnpaid) {
        $offerItem->offer->update([
          'status' => 'completed',
        ]);
      }

      // store palce holed transaction for now

      $customer = $project->customer;
      $paymentData = [
        'amount' => $offerItem->paymentSchedule->amount,
        'payment_schedule_id' => $offerItem->paymentSchedule->id,
        'contract_id' => $offerItem->offer->contract->id,
        'status' => 'hold',
        'transaction_reference' => $transactionReference,
        'provider_id' => $offerItem->offer->provider_id,
      ];

      $transaction = new PaymentTransaction($paymentData);

      $transaction->sender()->associate($customer);
      $transaction->beneficiary()->associate($offerItem->offer->provider);
      $transaction->save();
      
    } 
    // elseif ($offerItem->type == 'admin') {
      // Check if this was the last unpaid item
      $remainingUnpaid = $offerItem
        ->offer
        ->itemsWithSelectedServices()
        ->where('status', '!=', OfferItemStatus::PAID)
        ->exists();

        // 
      if (!$remainingUnpaid) {
        $offerItem->offer->project->update([
          'status' => ProjectStatus::COMPLETED,
        ]);
      }
    // }


  }

   public function processStagePayment($stageId, $transactionReference)
    {

      $exists = PaymentTransaction::where(
            'transaction_reference',
            $transactionReference
        )->exists();
        // 🔐 Idempotency
        if ($exists) {
            return;
        }

        $offerItem = OfferItem::findOrFail($stageId);
        $offerItem->update(['status' => OfferItemStatus::PAID]);

        if ($offerItem->type === 'provider') {
            $offerItem->paymentSchedule()->update(['status' => 'paid']);

            PaymentTransaction::create([
                'amount' => $offerItem->paymentSchedule->amount,
                'payment_schedule_id' => $offerItem->paymentSchedule->id,
                'contract_id' => $offerItem->offer->contract->id,
                'status' => 'hold',
                'transaction_reference' => $transactionReference,
                'provider_id' => $offerItem->offer->provider_id,
                'sender_id' => $offerItem->offer->project->customer_id,
            ]);
        }

        $remaining = $offerItem->offer
            ->itemsWithSelectedServices()
            ->where('status', '!=', OfferItemStatus::PAID)
            ->exists();

        if (!$remaining) {
            $offerItem->offer->project->update([
                'status' => ProjectStatus::COMPLETED
            ]);
        }
    }


   public function setSelectedAdditionServices($data, $offerId)
    {
        $data = is_array($data) ? $data : [];

        $offer = Offer::find($offerId);

        return $offer->additionalServices()->whereIn('id', $data)->update(['selected' => 1]);
    }
}
