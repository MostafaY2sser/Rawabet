<?php

namespace App\Repositories\Admin;

use App\Enums\InspectionStatus;
use App\Enums\OfferItemStatus;
use App\Enums\OfferStatus;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\PaymentSchedule;
use App\Utils\OfferUtility;

class OfferRepository{
    public function getPendingOffers()
    {
        // Logic to retrieve pending offers from the database

        $statuses = [OfferStatus::PENDING];

        return Offer::whereIn('status', array_map(fn($status) => $status->value, $statuses))->get();
    }
      public function getPendingOffersQuery()
    {
        // Logic to retrieve pending offers from the database

        $statuses = [OfferStatus::PENDING];

        return Offer::with('project')->whereIn('status', array_map(fn($status) => $status->value, $statuses))->orderBy("id" , 'desc')->get();
    }


    public function getActiveOffers()
    {

        $statuses = [OfferStatus::ACCEPTED  , OfferStatus::APPROVED];

        return Offer::whereIn('status', array_map(fn($status) => $status->value, $statuses))->get();
    }

    public function getActiveOffersQuery()
    {
        // Logic to retrieve active offers from the database

        $statuses = [OfferStatus::ACCEPTED  , OfferStatus::APPROVED];

        return Offer::with('project')->whereIn('status', array_map(fn($status) => $status->value, $statuses))->orderBy("id" , 'desc');
    }

    public function getCompletedOffers()
    {
        // Logic to retrieve completed offers from the database

        $statuses = [OfferStatus::COMPLETED];

        return Offer::whereIn('status', array_map(fn($status) => $status->value, $statuses))->orderBy("id" , 'desc')->get();
    }
    public function getCompletedOffersQuery()
    {
        // Logic to retrieve completed offers from the database

        $statuses = [OfferStatus::COMPLETED];

        return Offer::with('project')->whereIn('status', array_map(fn($status) => $status->value, $statuses))->orderBy("id" , 'desc');
    }

    public function getCanceledOffers()
    {
        // Logic to retrieve canceled offers from the database

        $statuses = [OfferStatus::DECLINED];

        return Offer::whereIn('status', array_map(fn($status) => $status->value, $statuses))->get();
    }

    public function find($id)
    {
        return Offer::find($id);
    }



    public function updateOfferItemProgress($data){

        $offerItem = OfferItem::find($data['item_id']);


        $status = $data['status'];

        if($status != OfferItemStatus::REQUESTPAYMENT->value){
        if($data['progress'] > 0)
        $status = OfferItemStatus::ACTIVE->value;

        if($data['progress'] == 100)
        $status = OfferItemStatus::COMPLETED->value;

        }


        $originalStatus = $offerItem->status;

        if($originalStatus == OfferItemStatus::COMPLETED->value &&  $offerItem->inspection && $status != OfferItemStatus::REQUESTPAYMENT){
            $offerItem->Inspection->update(
                [
                    "status"=>"cancelled"
                ]
                );
        }
        

        $offerItem->update([
            "progress"=>$data['progress'],
            "comments"=>$data['comments'],
            "status"=>$status,
        ]);

        

        if(!empty($data['images'])){
            foreach($data['images'] as $image){
                $offerItem->attachments()->create([
                    "file_path"=>$image['file_path']
                ]);
            }
        }

    }


    public function update($data){

        $offer = Offer::find($data['offer_id']);
        $offer->update($data);
        return $offer;
    }
    public function updatePaymentSchedule($data){

        
        $item = PaymentSchedule::find($data['_id']);
        unset($data['_id']);
        $item->update($data);

        return $item;
        

        
    }

       public function createAddtionalServices($items , $offer_id)
    {

        $offer = Offer::find($offer_id);
        if(count($offer->additionalServices) > 0){
        $offer->additionalServices()->delete();
        }
        foreach ($items as $item) {
            $item['amount_percentage'] =0;
            $item['offer_id'] = $offer->id;
            $item['type'] = 'admin';
            OfferItem::create($item);
        }

        // OfferUtility::generateAutoPaymentScheduleforAddtionalServices($offer->id);

        return $offer;
    }
}