<?php

namespace App\Services\Provider;

use App\Enums\ProjectStatus;
use App\Models\Offer;
use App\Repositories\Provider\OfferRepository;

class OfferService
{
    // Your existing methods

    /**
     * Get all offers by provider ID (basic version).
     *
     * @param int $providerId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOffersByProviderId($providerId)
    {
        return Offer::where('provider_id', $providerId)->get();
    }

    protected $offerRepo;

    public function __construct(OfferRepository $offerRepo)
    {
        $this->offerRepo = $offerRepo;
    }

    public function create($data)
    {
        $total_amount = 0;
        $items = [];

        $offerData = [
            'total_days' => $data['duration'],
            'expected_end_date' => $data['expectedFinish'],
            'project_id' => $data['project_id'],
            'provider_id' => $data['provider_id']
        ];

        $startDate = null;
        foreach ($data['items'] as $key => $item) {
            if ($key = 0) {
                $startDate = $item['start_date'];
            }
            $items[] = [
                'title' => $item['title'],
                'description' => $item['description'],
                'total_days' => $item['duration'],
                'order' => $key + 1,
                'amount' => $item['amount'],
                'start_date' => $item['start_date'],
                "end_date"=>$item['end_date'],
                'specifications'=>$item['specifications']
            ];
            $total_amount += $item['amount'];
        }
        $offerData['total_amount'] = $total_amount;
        $offerData['start_date'] = $data['items'][0]['start_date'];

        return $this->offerRepo->create($offerData, $items);
    }

    public function getOfferById($id)
    {
        return Offer::findOrFail($id);
    }

    public function getAllOffersByProvider($providerId)
    {
        return Offer::where('provider_id', $providerId);
    }


    public function updateOfferItemProgress($data){
        $this->offerRepo->updateOfferItemProgress($data);
    }
    
}
