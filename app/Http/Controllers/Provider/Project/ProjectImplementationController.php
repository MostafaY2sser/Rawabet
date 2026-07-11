<?php

namespace App\Http\Controllers\Provider\Project;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\OfferItem;
use App\Models\Project;
use App\Models\Provider;
use App\Services\Provider\OfferService;
use App\Utils\OfferUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectImplementationController extends Controller
{
    protected $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    public function index($project_id)
    {
        $provider = Auth::guard('provider')->user();

        $project = Project::find($project_id);

        // check for access

        $this->hasAccess($project, $provider);
          $attachments = [];

        foreach (config('project.files') as $type) {
             if (in_array($type['name'], config('project.viewable_files_for_provider'))) {
                $attachments[$type['label']] = $project->attachments()->where('file_name', $type['name'])->get();
            }
        }

        $offer = $project->acceptedOffer();

        $stagesInfo = OfferUtility::providerOfferStages($offer);

        return view('provider.project.implementation.index', compact('offer','attachments' ,'stagesInfo'));
    }

    public function showUpdateProgressFrom($item_id)
    {
        $offerItem = OfferItem::find($item_id);
        $provider = $offerItem->offer->provider;

        $project = $offerItem->offer->project;
        $this->hasAccess($project, $provider);

        return view('provider.project.implementation.update-progress', compact('offerItem'));
    }

    public function updateProgress(Request $request, $item_id)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'nullable|array',
            'images.*' => 'nullable|image',  // changed "image.*" to "images.*"
            'progress' => 'required|numeric|between:0,100',  // corrected rule
            'comments' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'msg' => $validator->errors()->first()
            ]);
        }

        $OfferItem = OfferItem::find($item_id);

        $images = [];
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $file_path = $image->store('project-updates', 'public');
                $images[] = ['file_path' => $file_path];
            }
        }

        
        $this->offerService->updateOfferItemProgress([
            'item_id' => $OfferItem->id,
            'progress' => $request->progress,
            'comments' => $request->comments,
            "status"=>$request->status,
            'images' => $images
        ]);
          return response()->json([
                'success' => true,
                'msg' =>"updated succesfully"
            ]);
    }

    public function hasAccess(Project $project, Provider $provider)
    {
        $hasAccess = $provider->activeProjects()->contains($project->id);
        if (!$hasAccess) {
            abort(403);
        }
    }
}
