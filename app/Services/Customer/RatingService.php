<?php
namespace App\Services\Customer;

use App\Repositories\Customer\RatingRepositry;

class RatingService{

    protected $ratingRepositry;
    public function __construct(RatingRepositry $ratingRepositry)
    {
        $this->ratingRepositry = $ratingRepositry;
    }
    public function store($data){
        $this->ratingRepositry->store($data);
    }
}