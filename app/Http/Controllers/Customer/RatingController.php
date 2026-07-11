<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\Customer\RatingService;
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
        $project = Project::findOrfail($id);
        $offer = $project->completedOffer();

         $this->canRate($project);

        return view('customer.rate.create', compact('project'));
    }

    public function store(Request $request, $id)
    {
        
        $request->validate([
            'contractor_rating' => 'required|integer|min:1|max:5',
            'contractor_comment' => 'nullable|string',
            'quality_rating' => 'required|integer|min:1|max:5',
            'quality_comment' => 'nullable|string',
            'punctuality_rating' => 'required|integer|min:1|max:5',
            'punctuality_comment' => 'nullable|string',
            'communication_rating' => 'required|integer|min:1|max:5',
            'communication_comment' => 'nullable|string',
            'platform_rating' => 'required|integer|min:1|max:5',
            'platform_comment' => 'nullable|string',
            'general_notes' => 'nullable|string',
        ]);

        $project  =Project::find($id);

        $this->canRate($project);
        
        $user = Auth::user('customer');


        $offer=   $project->acceptedOffer() ?? $project->completedOffer();

        // return $offer;
        $data = [
            'rater_id' => $user->id,
            'rater_type' => get_class($user),
            'project_id' => $id,
            'contractor_rating' => $request->input('contractor_rating'),
            'contractor_comment' => $request->input('contractor_comment'),

            'quality_rating' => $request->input('quality_rating'),
            'quality_comment' => $request->input('quality_comment'),
            'punctuality_rating' => $request->input('punctuality_rating'),
            'punctuality_comment' => $request->input('punctuality_comment'),
            'communication_rating' => $request->input('communication_rating'),
            'communication_comment' => $request->input('communication_comment'),
            'platform_rating' => $request->input('platform_rating'),
            'platform_comment' => $request->input('platform_comment'),
            'general_notes' => $request->input('general_notes'),
            'rated_id' => $offer->provider_id,
        ];

        $result = $this->ratingService->store($data);
        return redirect()->route('customer.project.implementation.index' , $id)->with('success' , 'rating added successfully');
    }

    public function canRate(Project $project)
    {
        
        if ((!$project->customer_id == Auth::user('customer')->id || !$project->completedOffer()))
            abort(403);
    }
}
