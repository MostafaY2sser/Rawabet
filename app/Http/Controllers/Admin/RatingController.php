<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    protected $ratingService;


    public function __construct(RatingService $ratingService)
    {
        
        $this->ratingService  = $ratingService;
    }

    public function providersRatings(){
         if(!Auth::user('admin')->can('view ratings'))
        abort(403);
        $ratings =  $this->ratingService->getProvidersRatings();

        return view('admin.ratings.providers.index' ,compact('ratings'));


    }
    public function showProvidersRatings($id){
          if(!Auth::user('admin')->can('view ratings'))
        abort(403);
    
        $rating =  $this->ratingService->getById($id);

        return view('admin.ratings.providers.show' ,compact('rating'));

    }

    public function customersRatings(){
          if(!Auth::user('admin')->can('view ratings'))
        abort(403);
        $ratings =  $this->ratingService->getcustomersRatings();

        return view('admin.ratings.customers.index' ,compact('ratings'));


    }
    public function showcustomersRatings($id){
          if(!Auth::user('admin')->can('view ratings'))
        abort(403);
        $rating =  $this->ratingService->getById($id);

        return view('admin.ratings.customers.show' ,compact('rating'));


    }
    
}
