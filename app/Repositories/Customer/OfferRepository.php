<?php

namespace App\Repositories\Customer;

use App\Enums\OfferStatus;
use App\Models\Offer;
use App\Utils\NotificationUtility;

class OfferRepository
{
    public function accept($data)
    {
        $offer = Offer::find($data['offer_id']);

        $selectedServices = $this->getSelectedAdditionServices($data['services'], $offer->id);

        unset($data['offer_id']);
        unset($data['services']);

        $offer->update(
            [
                'status' => OfferStatus::ACCEPTED->value
            ]
        );

        foreach ($selectedServices as $service) {
            $service->update(['selected' => 1]);
        }
        foreach ($offer->project->offers as $item) {
            if ($item->id == $offer->id)
                continue;

            $item->update([
                'status' => OfferStatus::DECLINED->value
            ]);
        }
        $project = $offer->project;
        $project->update([
            'accept_offer_date' => now()
        ]);

        return $offer;
    }

   

    public function getSelectedAdditionServices($data, $offerId)
    {
        $data = is_array($data) ? $data : [];

        $offer = Offer::find($offerId);

        return $offer->additionalServices()->whereIn('id', $data)->get();
    }
}
