<?php
namespace App\Repositories\Admin;

use App\Models\Customer;
use App\Models\Provider;
use App\Models\Rating;

class RatingRepositry{

    function getProvidersRatings(){
        $ratings =  Rating::where('rater_type' , Customer::class)->get();

        return $ratings;
    }
    function getCustomersRatings(){
        $ratings =  Rating::where('rater_type' , Provider::class)->get();

        return $ratings;
    }
}