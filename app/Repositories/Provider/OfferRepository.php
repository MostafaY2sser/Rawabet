<?php

namespace App\Repositories\Provider;

use App\Enums\OfferItemStatus;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Utils\OfferUtility;

class OfferRepository
{
    public function create($offerData, $items)
    {
        $offer = Offer::create($offerData);

        foreach ($items as $item) {
            $item['amount_percentage'] = ($item['amount'] / $offer->total_amount) * 100;
            $item['offer_id'] = $offer->id;
            OfferItem::create($item);
        }

        OfferUtility::generateAutoPaymentSchedule($offer->id);

        return $offer;
    }

    public function updateOfferItemProgress($data){

        $offerItem = OfferItem::find($data['item_id']);


        $status = $data['status'];
        if($data['progress'] > 0)
        $status = OfferItemStatus::ACTIVE->value;

        if($data['progress'] == 100)
        $status = OfferItemStatus::COMPLETED->value;

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
}
