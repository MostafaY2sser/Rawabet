<?php
namespace App\Services\Admin;

use App\Models\Rating;
use App\Repositories\Admin\RatingRepositry;

class RatingService{

    protected $ratingRepositry;
    public function __construct(RatingRepositry $ratingRepositry)
    {
        $this->ratingRepositry = $ratingRepositry;
    }
    public function getProvidersRatings(){
        return $this->ratingRepositry->getProvidersRatings();
    }
    public function getCustomersRatings(){
        return $this->ratingRepositry->getCustomersRatings();
    }

    public function getById($id){
        return Rating::find($id);
    }
}