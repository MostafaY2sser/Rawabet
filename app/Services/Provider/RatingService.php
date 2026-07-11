<?php
namespace App\Services\Provider;

use App\Repositories\Provider\RatingRepositry;

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