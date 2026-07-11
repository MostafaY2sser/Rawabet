<?php
namespace App\Services\Admin;

use App\Enums\OfferStatus;
use App\Repositories\Admin\OfferRepository;

class OfferService
{
    protected $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function getPendingOffers()
    {
        return $this->offerRepository->getPendingOffers();
    }

    public function getPendingOffersQuery()
    {
        return $this->offerRepository->getPendingOffersQuery();
    }

    public function getActiveOffers()
    {
        return $this->offerRepository->getActiveOffers();
    }
    public function getActiveOffersQuery()
    {
        return $this->offerRepository->getActiveOffersQuery();
    }

    public function getCompletedOffers()
    {
        return $this->offerRepository->getCompletedOffers();
    }

    public function getCompletedOffersQuery()
    {
        return $this->offerRepository->getCompletedOffersQuery();
    }

    public function getCanceledOffers()
    {
        return $this->offerRepository->getCanceledOffers();
    }
    public function getOfferById($id)
    {
        return $this->offerRepository->find($id);
    }

    public function update($data){
        return $this->offerRepository->update($data);
    }
    public function updateOfferItemProgress($data){
        $this->offerRepository->updateOfferItemProgress($data);
    }
    public function updatePaymentSchedule($data){
        return $this->offerRepository->updatePaymentSchedule($data);
    }

     public function createAdditionalServices($data)
    {
        $items = [];

   

        $offer_id = $data['offer_id'];
        foreach ($data['items'] as $key => $item) {
           
            $items[] = [
                'title' => $item['title'],
                'description' => $item['description'],
                'total_days' => $item['duration'],
                'order' => $key + 1,
                'amount' => $item['amount'],
                'start_date' => $item['start_date'],
                "end_date"=>$item['end_date'],
                'specifications'=>$item['specifications'] ?? ''
            ];
        }


        return $this->offerRepository->createAddtionalServices($items , $offer_id);
    }

} 