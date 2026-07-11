<?php

namespace App\Http\Controllers\Provider;

use App\Enums\OfferStatus;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Project;
use App\Services\Provider\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function create($id)
    {
        $offer = Offer::with('project')->findOrfail($id);

        if (!$this->canRate($offer))
            abort(403);

        return view('provider.rate.create', compact('offer'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'customer_rating' => 'required|integer|min:1|max:5',
            'customer_comment' => 'nullable|string',
            'platform_rating' => 'required|integer|min:1|max:5',
            'platform_comment' => 'nullable|string',
            'general_notes' => 'nullable|string',
        ]);

        $offer = Offer::find($id);

        if (!$this->canRate($offer))
            abort(403);
        $user = Auth::user('provider');

        $data = [
            'rater_id' => $user->id,
            'rater_id'=>$offer->project->customer_id,
            'rater_type' => get_class($user),
            'project_id' => $offer->project->id,
            'customer_rating' => $request->input('customer_rating'),
            'customer_comment' => $request->input('customer_comment'),
            'platform_rating' => $request->input('platform_rating'),
            'platform_comment' => $request->input('platform_comment'),
            'general_notes' => $request->input('general_notes'),
        ];


        $result = $this->ratingService->store($data);
        return redirect()->route('provider.offers.show', $offer->id)->with('success', 'rating added successfully');
    }

    public function canRate(Offer $offer)
    {
        $user = Auth::user('provider');  // Get currently logged-in customer

        // Check if user is the customer of this project
        if ($offer->provider_id !== $user->id) {
            return false;
        }

        // Check if the project has an accepted offer
        if ($offer->status != OfferStatus::COMPLETED->value) {
            return false;
        }

        // Check if the project already has a rating (assuming $project->rating exists and means rating exists)
        if ($offer->project->rating()->where('rater_type', get_class($user))->count() != 0) {
            return false;
        }

        return true;
    }
}
