<?php

namespace App\Http\Controllers\Provider\Offer;

use App\Enums\OfferStatus;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectAttachment;
use App\Services\Provider\OfferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    protected $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    public function index(Request $request)
    {
        $providerId = Auth::guard('provider')->user()->id;
        $offersQuery = $this->offerService->getAllOffersByProvider($providerId);
        if ($request->filled('status') && $request->status != 'all') {
            if ($request->status == OfferStatus::APPROVED->value) {
                $offersQuery->where('status', '<>', OfferStatus::PENDING->value);
            } else
                $offersQuery->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $offersQuery->whereHas('project', function ($q) use ($search) {
                $q->whereHas('buildingType', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $offers = $offersQuery
            ->with(['project', 'project.buildingType'])
            ->get();

        $allCounts = [
            'all' => $this->offerService->getAllOffersByProvider($providerId)->count(),
            'pending' => $this->offerService->getAllOffersByProvider($providerId)->where('status', OfferStatus::PENDING->value)->count(),
            'approved' => $this->offerService->getAllOffersByProvider($providerId)->where('status', '<>', OfferStatus::PENDING->value)->count(),
            'accepted' => $this->offerService->getAllOffersByProvider($providerId)->where('status', OfferStatus::ACCEPTED->value)->count(),
            'require_update' => $this->offerService->getAllOffersByProvider($providerId)->where('status', OfferStatus::REQUIRE_UPDATE->value)->count(),
            'declined' => $this->offerService->getAllOffersByProvider($providerId)->where('status', OfferStatus::DECLINED->value)->count(),
        ];
        return view('provider.offer.index', compact('offers', 'allCounts'));
    }

    public function show($id)
    {
        $offer = $this->offerService->getOfferById($id);

        $canRate = $this->canRate($offer);
        $attachments = [];

        foreach (config('project.files') as $type) {
            if (in_array($type['name'], config('project.viewable_files_for_provider'))) {
                $attachments[$type['label']] = $offer->project->attachments()->where('file_name', $type['name'])->get();
            }
        }
        return view('provider.offer.details', compact('offer', 'attachments' , 'canRate'));
    }

    public function create($id)
    {
        $project = Project::findorfail($id);

        $this->canCreateOffer($project);
        if ($project->status != ProjectStatus::OPEN_FOR_OFFERS->value)
            abort(403);

        return view('provider.offer.create', compact('project'));
    }

    public function store($id, Request $request)
    {
        $request->validate([
            'duration' => ['required', 'integer', 'min:1'],
            'expectedFinish' => ['required', 'date'],
            'action' => ['required', 'in:submit,draft'],  // Adjust allowed actions if needed
            'items' => ['required', 'array', 'min:1'],
            'items.*.title' => ['required', 'string'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.duration' => ['required', 'integer', 'min:1'],
            'items.*.amount' => ['required', 'numeric', 'min:0'],
            'items.*.start_date' => ['required', 'date'],
            'items.*.end_date' => ['required', 'date'],
            'items.*.specifications' => ['nullable', 'string'],
        ]);

        $project = Project::findorfail($id);

        if ($project->status != ProjectStatus::OPEN_FOR_OFFERS->value)
            abort(403);

        $data = $request->except('items', '_token', 'action');
        $data['items'] = $request->input('items');
        $data['project_id'] = $id;
        $data['provider_id'] = Auth::guard('provider')->user()->id;

        $this->offerService->create($data);
        return redirect()->route('provider.project.index')->with('success', 'created successfully');
    }

public function canCreateOffer(Project $project)
{
    $userId = auth('provider')->id(); // Get the current authenticated user ID

    $existedOffer = $project->offers()
        ->where('provider_id', $userId)
        ->exists();

    $projectStatusIsOpen = $project->status == ProjectStatus::OPEN_FOR_OFFERS->value;

    if ($existedOffer || !$projectStatusIsOpen) {
        abort(403, 'You are not allowed to create an offer for this project.');
    }
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
    if ($offer->project->rating()->where('rater_type' , get_class($user))->count() !=  0 ) {
        return false;
    }

    return true;
}


}
