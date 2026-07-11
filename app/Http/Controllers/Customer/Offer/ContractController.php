<?php

namespace App\Http\Controllers\Customer\Offer;

use App\Enums\ContractStatus;
use App\Enums\OfferStatus;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Services\Customer\ContractService;
use App\Services\Customer\OfferService;
use App\Services\Customer\PaymentService;
use App\Services\Customer\PerojectService;
use App\Utils\NotificationUtility;
use App\Utils\OfferUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Storage;

class ContractController extends Controller
{
    protected $offerService,
        $contractService,
        $projectService;

    public function __construct(OfferService $offerService, ContractService $contractService, PerojectService $projectService)
    {
        $this->contractService = $contractService;
        $this->offerService = $offerService;
        $this->projectService = $projectService;
    }


    public function sign(Request $request, $id)
    {
        $offer = Offer::with('contract', 'project')->findOrFail($id);

        if ($offer->project->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        if ($request->isMethod('post') && $request->has('services')) {
            $this->offerService->setSelectedAdditionServices($request->services, $offer->id);

            return redirect()->route('customer.contract.sign', $offer->id);
        }

        $selectedServices = $offer->additionalServices()->where('selected', 1)->get();
        $details = OfferUtility::getDetails($offer);

        return view('customer.contract.sign', [
            'offer' => $offer,
            'selectedServices' => $selectedServices,
            'details' => $details,
            'step' => $this->resolveSignStep($offer),
        ]);
    }

    protected function resolveSignStep(Offer $offer): string
    {
        $contract = $offer->contract;

        if (!$contract || !$contract->deposit_paid) {
            return 'deposite';
        }

        if (!$contract->mobile_verified) {
            return 'mobile_verification';
        }

        if (!$contract->signtured) {
            return 'contract_sign';
        }

        return 'project_start';
    }

    public function verifyMobile(Request $request)
    {
        $code = $request->verification_code;
        $offer = Offer::findorfail($request->offer_id);

        if ($offer->project->customer_id != auth('customer')->user()->id)
            abort(404);

        if ($offer->contract->mobile_verification == $code) {
            $this->contractService->update(
                [
                    'mobile_verified' => 1,
                    'contract_id' => $offer->contract->id
                ]
            );
            return response(['success' => true]);
        } else {
            return response([
                'success' => false,
                'message' => 'Incorrect code',
            ], 200);
        }
    }

    public function compeleteSign(Request $request)
    {
        $offer = Offer::findorfail($request->offer_id);
        $fileName = '';
        if ($offer->project->customer_id != auth('customer')->user()->id)
            abort(404);

        if ($request->signature) {
            $exploded = explode(',', $request->signature);
            $decoded = base64_decode($exploded[1]);

            $fileName = 'signatures/signature_' . $offer->id . '_' . time() . '.png';
            FacadesStorage::disk('public')->put($fileName, $decoded);
        }

        DB::beginTransaction();

        try {
            $this->contractService->update(
                [
                    'contract_id' => $offer->contract->id,
                    'signtured' => 1,
                    'signature_date' => now()->toDateString(),  // 'Y-m-d'
                    'signature_time' => now()->toTimeString(),  // 'H:i:s'
                    'signature_path' => $fileName,
                    'comments' => $request->additional_notes,
                    'status' => ContractStatus::ACTIVE->value
                ]
            );

            $this->offerService->accept([
                'offer_id' => $offer->id,
                'services'=>$request->services
            ]);

            $this->projectService->update(
                [
                    'project_id' => $offer->project->id,
                    'status' => ProjectStatus::IN_PROGRESS->value
                ]
            );
            

            DB::commit();
            return response(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();

            // You can log the error or return a proper error response
            return response([
                'success' => false,
                'message' => 'Transaction failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
