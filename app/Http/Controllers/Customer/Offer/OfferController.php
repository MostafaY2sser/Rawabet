<?php

namespace App\Http\Controllers\Customer\Offer;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index($id){

        $project = Project::with(['approvedOffers.contract', 'approvedOffers.provider'])->findOrFail($id);


        if($project->status != ProjectStatus::OPEN_FOR_OFFERS->value)
        abort(403);

        
        return view('customer.offers.index' , compact('project'));
    }
}
