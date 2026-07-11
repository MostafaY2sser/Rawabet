<?php

namespace App\Http\Controllers\Customer\Project;

use App\Enums\OfferItemStatus;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OfferItem;
use App\Models\Project;
use App\Models\Rating;
use App\Services\Customer\OfferService;
use App\Utils\OfferUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class ProjectImplementationController extends Controller
{
    protected $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    public function index($project_id)
    {
        $customer = Auth::guard('customer')->user();

        $project = Project::find($project_id);

        // check for access

        if ($project->status == ProjectStatus::COMPLETED->value) {
            return redirect()->route('customer.project.show.compeleted', $project->id);
        }
        $this->hasAccess($project, $customer);

        $canRate = $this->canRate($project);

        $offer = $project->acceptedOffer();

        if (!$offer) {
            abort(404);
        }

        $offer->loadMissing('provider', 'contract');

        $details = OfferUtility::getDetails($offer);

        $averageRate = $offer->provider?->ratingsQuery()?->avg('contractor_rating');

        return view('customer.project.implementation.index', compact('offer', 'project', 'canRate', 'details', 'averageRate'));
    }

    public function showRequestChangeForm($project_id)
    {
        $customer = Auth::guard('customer')->user();

        $project = Project::find($project_id);

        // check for access

        $this->hasAccess($project, $customer);

        $offer = $project->acceptedOffer();

        if (!$offer) {
            abort(404);
        }

        $offer->loadMissing('provider', 'contract');

        $details = OfferUtility::getDetails($offer);

        $averageRate = $offer->provider?->ratingsQuery()?->avg('contractor_rating');

        return view('customer.project.implementation.request-change', compact('offer', 'project', 'details', 'averageRate'));
    }

    
    public function acceptStagePayment($project_id, $itemId)
    {
        $customer = Auth::guard('customer')->user();

        $project = Project::find($project_id);

        // check for access

        $this->hasAccess($project, $customer);


        $offerItem = OfferItem::find($itemId);

        if ($offerItem->status != OfferItemStatus::REQUESTPAYMENT->value) {
            return redirect()
                ->back()
                ->with('error', 'لا يمكن الدفع لأنه غير مكتمل.');
        }

        $result = $this->offerService->acceptStagePayment($offerItem->id);

        if ($result)
            return redirect()->back()->with('success', 'stage status updated ');
    }

    public function hasAccess(Project $project, Customer $customer)
    {
        $hasAccess = false;
        if ($project->customer_id == $customer->id && $project->status == ProjectStatus::IN_PROGRESS->value)
            $hasAccess = true;
        if (!$hasAccess) {
            abort(403);
        }
    }

    public function canRate(Project $project)
    {
        $user = Auth::user('customer');  // Get currently logged-in customer

        // Check if user is the customer of this project
        if ($project->customer_id !== $user->id) {
            return false;
        }

        // Check if the project has an accepted offer
        if (is_null($project->completedOffer())) {
            return false;
        }

        // Check if the project already has a rating (assuming $project->rating exists and means rating exists)
        if ($project->rating()->where('rater_type', get_class($user))->count() != 0) {
            return false;
        }

        return true;
    }
}
