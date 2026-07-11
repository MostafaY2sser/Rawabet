<?php
namespace App\Repositories\Provider;

use App\Models\Rating;

class RatingRepositry{

    function store($data){

     $rate =    Rating::create($data);
     return $rate;
    }
}