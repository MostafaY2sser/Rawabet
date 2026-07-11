<?php
namespace App\Utils;

use App\Enums\OfferItemStatus;
use App\Enums\ProjectStatus;
use App\Models\Consultant;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\PaymentSchedule;
use App\Models\Project;

class OfferUtility
{

   

public static function generateAutoPaymentSchedule($offer_id)
{
    $offer = Offer::with('items')->findOrFail($offer_id); // assumes 'items' relation
    $items = $offer->items;
    

    if ($items->isEmpty()) {
        throw new \Exception("No offer items found for this offer.");
    }

    $totalPrice = $offer->total_amount; // adjust if your field is named differently

    // 1. Create deposit payment (10%)
    $depositPercentage = 10;
    $depositAmount = round(($totalPrice * $depositPercentage) / 100, 2);

    PaymentSchedule::create([
        'title' => 'دفعة مقدمة',
        'amount' => $depositAmount,
        'percentage' => $depositPercentage,
        'type' => 'deposite',
        'offer_id' => $offer->id,
        'stage_id' => null,
    ]);

    // 2. Distribute remaining 90% across all offer items
    $remainingPercentage = 90;
    $itemCount = $items->count();
    $perItemPercentage = round($remainingPercentage / $itemCount, 2);

    foreach ($items as $item) {
        $amount = round(($totalPrice * $perItemPercentage) / 100, 2);

        PaymentSchedule::create([
            'title' => 'دفعة مرحلة: ' . ($item->title ?? 'بدون اسم'),
            'amount' => $amount,
            'percentage' => $perItemPercentage,
            'type' => 'stage',
            'offer_id' => $offer->id,
            'stage_id' => $item->id,
        ]);
    }
}


public static function generateAutoPaymentScheduleforAddtionalServices($offer_id)
{
    $offer = Offer::findOrFail($offer_id); // assumes 'items' relation
    $items = $offer->additionalServices;

    if ($items->isEmpty()) {
        throw new \Exception("No offer items found for this offer.");
    }


    foreach ($items as $item) {

        PaymentSchedule::create([
            'title' => 'دفعة مرحلة: ' . ($item->title ?? 'بدون اسم'),
            'amount' => $item->amount,
            'percentage' => 0,
            'type' => 'stage',
            'offer_id' => $offer->id,
            'stage_id' => $item->id,
        ]);
    }
}



public static function getDetails(Offer $offer){

    $data['total_days'] = $offer->total_days;

    $data['total_amount_no_extra']  =$offer->total_amount;
    
    $data['extra_services'] = $offer->additionalServices()->where('selected', 1)->sum('amount');

     $data['total_amount_with_extra'] = $data['total_amount_no_extra'] + $data['extra_services'];

     $data['deposite_amount']  = $offer->deposite()->amount;
     $data['tax_percentage'] = getTaxPercentage($offer);
     $data['tax_amount'] = getTaxAmount($data['total_amount_with_extra'], $data['tax_percentage']);
     $data['total_amount_with_tax'] = $data['total_amount_with_extra'] + $data['tax_amount'];
     $data['deposite_tax_amount'] = getTaxAmount($data['deposite_amount'], $data['tax_percentage']);
     $data['deposite_amount_with_tax'] = $data['deposite_amount'] + $data['deposite_tax_amount'];
     $data['remaining_with_tax'] = $data['total_amount_with_tax'] - $data['deposite_amount_with_tax'];


     $data['paid_no_extra'] = $offer->paymentSchedules()->where('status' , OfferItemStatus::PAID)->sum('amount');

     $data['paid_extra'] = $offer->additionalServices()->where('status' , OfferItemStatus::PAID)->sum('amount');

     $data['paid_with_extra'] = $data['paid_no_extra'] + $data['paid_extra'];
     $paidSchedulesTaxInclusive = $offer->paymentSchedules()
         ->where('status', OfferItemStatus::PAID->value)
         ->get()
         ->sum(fn (PaymentSchedule $schedule) => $schedule->amount + getTaxAmount($schedule->amount, $data['tax_percentage']));
     $paidExtrasTaxInclusive = $offer->additionalServices()
         ->where('selected', 1)
         ->where('status', OfferItemStatus::PAID->value)
         ->get()
         ->sum(fn ($service) => $service->amount + getTaxAmount($service->amount, $data['tax_percentage']));
     $data['paid_with_tax'] = $paidSchedulesTaxInclusive + $paidExtrasTaxInclusive;
     $data['outstanding_with_tax'] = max(0, $data['total_amount_with_tax'] - $data['paid_with_tax']);
     $data['start_date'] = $offer->start_date;
     $data['end_date'] = $offer->expected_end_date;


     return $data;


    
}

public static function providerOfferStages(Offer $offer): array
{
    $itemsQuery = $offer->items();

    // 1. Count finished stages (COMPLETED or REQUESTPAYMENT)
    $finishedStages = (clone $itemsQuery)
        ->whereIn('status', [
            OfferItemStatus::COMPLETED->value,
            OfferItemStatus::REQUESTPAYMENT->value
        ])
        ->count();

    // 2. Calculate overall progress
    $totalProgress = (clone $itemsQuery)->sum('progress');
    $itemCount = (clone $itemsQuery)->count();
    $overallProgress = $itemCount > 0 ? round($totalProgress / $itemCount, 2) : 0;

    // 3. Get active stage with fallback
    $activeStage = (clone $itemsQuery)
        ->where('status', OfferItemStatus::ACTIVE->value)
        ->first();

    if (!$activeStage) {
        $activeStage = (clone $itemsQuery)
            ->where('status', OfferItemStatus::PENDING->value)
            ->first();
    }

    if (!$activeStage) {
        $activeStage = (clone $itemsQuery)
            ->whereIn('status', [
                OfferItemStatus::REQUESTPAYMENT->value,
                OfferItemStatus::COMPLETED->value
            ])
            ->orderBy('id')
            ->first();
    }

    
    return [
        'finishedStages'   => $finishedStages,
        'overallProgress'  => $overallProgress,
        'activeStage'      => $activeStage,
    ];
}


}
