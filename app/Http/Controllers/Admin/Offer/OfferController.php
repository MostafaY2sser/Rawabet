<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Enums\OfferStatus;
use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\PaymentSchedule;
use App\Models\Project;
use App\Utils\OfferUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    protected $offerService;

    public function __construct(\App\Services\Admin\OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    public function pendingOffers(Request $request)
    {
        if (!Auth::user('admin')->can('view offers.pending'))
            abort(403);

        if ($request->ajax()) {
            $offers = $this->offerService->getPendingOffersQuery();

            return DataTables::of($offers)
                ->addColumn('provider_name', fn($row) => $row->provider?->company_name)
                ->addColumn('project_type', fn($row) => $row->project?->projectType->name)
                ->addColumn('reference_number', fn($row) => $row->project->reference_number ?? '')
                ->addColumn('category', fn($row) => $row->project->category?->name)
                ->addColumn('region', fn($row) => $row->project->region?->name)
                ->addColumn('total_amount', fn($row) => $row->total_amount)
                ->addColumn('start_date', fn($row) => $row->start_date)
                ->addColumn('status', fn($row) => \App\Enums\OfferStatus::getLabel($row->status))
                ->addColumn('action', function ($row) {
                    $actions = '';
                    if (auth()->user()->can('view offers.pending')) {
                        $actions .= '<a href="' . route('admin.offers.pending.edit', $row->id) . '" style="margin-inline-end:8px;">
                                <i class="fa-regular fa-eye"></i>
                            </a>';
                    }

                    if (auth()->user()->can('draft offers.pending')) {
                        $actions .= '<form action="' . route('admin.offers.pending.draft', $row->id) . '" method="POST" style="display:inline-block;" onsubmit="return confirm(\'هل تريد نقل العرض إلى المسودة؟\');">'
                            . csrf_field()
                            . '<button type="submit" class="btn btn-sm btn-warning">مسودة</button>'
                            . '</form>';
                    }

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.offers.pending.index');
    }

    public function activeOffers(Request $request)
    {
        if (!Auth::user('admin')->can('view offers.active'))
            abort(403);


            if ($request->ajax()) {
            $offers = $this->offerService->getActiveOffersQuery();

             if ($request->status) {
        $offers->where('status', $request->status);
    }
            return DataTables::of($offers)
                ->addColumn('provider_name', fn($row) => $row->provider?->company_name)
                ->addColumn('project_type', fn($row) => $row->project?->projectType->name)
                ->addColumn('reference_number', fn($row) => $row->project->reference_number ?? '')
                ->addColumn('category', fn($row) => $row->project->category?->name)
                ->addColumn('region', fn($row) => $row->project->region?->name)
                ->addColumn('total_amount', fn($row) => $row->total_amount)
                ->addColumn('start_date', fn($row) => $row->start_date)
                ->addColumn('status', fn($row) => \App\Enums\OfferStatus::getLabel($row->status))
                ->addColumn('action', function ($row) {
                    if (auth()->user()->can('view offers.active')) {
                        return '<a href="' . route('admin.offers.active.show', $row->id) . '">
                                <i class="fa-regular fa-eye"></i>
                            </a>';
                    }
                    return '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.offers.active.index');
    }

    public function compeletedOffers(Request $request)
    {
        if (!Auth::user('admin')->can('view offers.completed'))
            abort(403);

             if ($request->ajax()) {
            $offers = $this->offerService->getCompletedOffersQuery();

             if ($request->status) {
        $offers->where('status', $request->status);
    }
            return DataTables::of($offers)
                ->addColumn('provider_name', fn($row) => $row->provider?->company_name)
                ->addColumn('project_type', fn($row) => $row->project?->projectType->name)
                ->addColumn('reference_number', fn($row) => $row->project->reference_number ?? '')
                ->addColumn('category', fn($row) => $row->project->category?->name)
                ->addColumn('region', fn($row) => $row->project->region?->name)
                ->addColumn('total_amount', fn($row) => $row->total_amount)
                ->addColumn('start_date', fn($row) => $row->start_date)
                ->addColumn('status', fn($row) => \App\Enums\OfferStatus::getLabel($row->status))
                ->addColumn('action', function ($row) {
                    if (auth()->user()->can('view offers.completed')) {
                        return '<a href="' . route('admin.offers.compeleted.show', $row->id) . '">
                                <i class="fa-regular fa-eye"></i>
                            </a>';
                    }
                    return '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

            return view('admin.offers.compeleted.index');
    }

    public function draftedOffers(Request $request)
    {
        if (!Auth::user('admin')->can('view offers.drafted')) {
            abort(403);
        }

        if ($request->ajax()) {
            $offers = Offer::with('project')
                ->where('status', OfferStatus::DRAFT->value)
                ->orderByDesc('id')
                ->get();

            return DataTables::of($offers)
                ->addColumn('provider_name', fn($row) => $row->provider?->company_name)
                ->addColumn('project_type', fn($row) => $row->project?->projectType->name)
                ->addColumn('reference_number', fn($row) => $row->project->reference_number ?? '')
                ->addColumn('category', fn($row) => $row->project->category?->name)
                ->addColumn('region', fn($row) => $row->project->region?->name)
                ->addColumn('total_amount', fn($row) => $row->total_amount)
                ->addColumn('start_date', fn($row) => $row->start_date)
                ->addColumn('status', fn($row) => \App\Enums\OfferStatus::getLabel($row->status))
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('restore offers.drafted')) {
                        $actions .= '<form action="' . route('admin.offers.drafted.restore', $row->id) . '" method="POST" style="display:inline-block;margin-inline-end:6px;">'
                            . csrf_field()
                            . '<button type="submit" class="btn btn-sm btn-success">استعادة</button>'
                            . '</form>';
                    }

                    if (auth()->user()->can('delete offers.drafted')) {
                        $actions .= '<form action="' . route('admin.offers.drafted.delete', $row->id) . '" method="POST" style="display:inline-block;" onsubmit="return confirm(\'هل أنت متأكد من حذف العرض؟\');">'
                            . csrf_field()
                            . '<button type="submit" class="btn btn-sm btn-danger">حذف</button>'
                            . '</form>';
                    }

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.offers.drafted.index');
    }

    public function restoreDraft($id)
    {
        if (!Auth::user('admin')->can('restore offers.drafted')) {
            abort(403);
        }

        $offer = Offer::findOrFail($id);
        if ($offer->status !== OfferStatus::DRAFT->value) {
            return redirect()->back()->with('error', 'العرض ليس في حالة المسودة.');
        }

        $offer->update(['status' => OfferStatus::PENDING->value]);

        return redirect()->back()->with('success', 'تمت استعادة العرض إلى قيد المراجعة.');
    }

    public function deleteDraft($id)
    {
        if (!Auth::user('admin')->can('delete offers.drafted')) {
            abort(403);
        }

        $offer = Offer::findOrFail($id);
        if ($offer->status !== OfferStatus::DRAFT->value) {
            return redirect()->back()->with('error', 'لا يمكن حذف عرض ليس في حالة المسودة.');
        }

        $offer->delete();

        return redirect()->back()->with('success', 'تم حذف العرض.');
    }

    public function edit($id)
    {
        if (!Auth::user('admin')->can('view offers.pending'))
            abort(403);
        $offer = $this->offerService->getOfferById($id);
        $data['project'] = $offer->project;
        $attachments = [];
        foreach (config('project.files') as $type) {
            $attachments[$type['label']] = $offer
                ->project
                ?->attachments()
                ->where('file_name', $type['name'])
                ->get();
        }
        $data['attachments'] = $attachments;

        $data['details'] = OfferUtility::getDetails($offer);

        if ($offer->status == OfferStatus::PENDING->value) {
            $consultations = Consultant::where('specialty_id', $offer->service_type)->get();
            $data['consultants'] = $consultations;
        }
        $data['offer'] = $offer;
        
        return view('admin.offers.pending.edit', $data);
    }

    public function showActiveOffer($id)
    {
        if (!Auth::user('admin')->can('edit offers.active'))
            abort(403);
        $offer = $this->offerService->getOfferById($id);
        $data['project'] = $offer->project;
        $attachments = [];
        foreach (config('project.files') as $type) {
            $attachments[$type['label']] = $offer
                ->project
                ?->attachments()
                ->where('file_name', $type['name'])
                ->get();
        }
        $data['attachments'] = $attachments;
        $data['details'] = OfferUtility::getDetails($offer);

        $data['offer'] = $offer;
        return view('admin.offers.active.show', $data);
    }

    public function showcompeletedOffer($id)
    {
        if (!Auth::user('admin')->can('view offers.completed'))
            abort(403);
        $offer = $this->offerService->getOfferById($id);
        $data['project'] = $offer->project;
        $attachments = [];
        foreach (config('project.files') as $type) {
            $attachments[$type['label']] = $offer
                ->project
                ?->attachments()
                ->where('file_name', $type['name'])
                ->get();
        }
        $data['attachments'] = $attachments;

        $data['offer'] = $offer;
        return view('admin.offers.compeleted.show', $data);
    }

    public function approve($id)
    {
        if (!Auth::user('admin')->can('approve offers.pending'))
            abort(403);
        $offer = Offer::findOrFail($id);
        if ($offer->status === OfferStatus::PENDING->value) {
            $data['offer_id'] = $offer->id;
            $data['status'] = OfferStatus::APPROVED->value;

            $this->offerService->update($data);

            return redirect()
                ->route('admin.offers.pending.index')
                ->with('success', 'تم اعتماد العرض بنجاح.');
        }

        return redirect()
            ->back()
            ->with('error', 'لا يمكن اعتماد العرض لأنه ليس قيد المراجعة.');
    }

    public function draftPending($id)
    {
        if (!Auth::user('admin')->can('draft offers.pending')) {
            abort(403);
        }

        $offer = Offer::findOrFail($id);
        if ($offer->status !== OfferStatus::PENDING->value) {
            return redirect()->back()->with('error', 'لا يمكن نقل العرض إلى المسودة إلا إذا كان قيد المراجعة.');
        }

        $offer->update(['status' => OfferStatus::DRAFT->value]);

        return redirect()->back()->with('success', 'تم نقل العرض إلى المسودة بنجاح.');
    }

    public function updatePaymentSchedules(Request $request, $id)
    {
        $percentages = $request->schedules;

        $offer = $this->offerService->getOfferById($id);

        foreach ($percentages as $paymentId => $newPercentage) {
            $newAmount = ($offer->total_amount * $newPercentage['percentage']) / 100;

            $result = $this->offerService->updatePaymentSchedule(['_id' => $paymentId, 'amount' => $newAmount, 'percentage' => $newPercentage['percentage']]);
        }

        return redirect()->back()->with('success', 'تم تحديث جدول الدفعات والبنود بنجاح ✅');
    }

    public function updateProgress(Request $request, $item_id)
    {
        if (!Auth::user('admin')->can('update projects.workstages'))
            abort(403);
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
            'status' => $request->status,
            'images' => $images
        ]);
        return response()->json([
            'success' => true,
            'msg' => 'updated succesfully'
        ]);
    }

    public function showUpdateProgressFrom($item_id)
    {
        if (!Auth::user('admin')->can('update projects.workstages'))
            abort(403);
        $offerItem = OfferItem::find($item_id);
        $provider = $offerItem->offer->provider;

        $project = $offerItem->offer->project;

        return view('admin.offers.active.update-progress', compact('offerItem'));
    }

    public function showAdditionalServices($id)
    {
        if (!Auth::user('admin')->can('view offers.additionalServices'))
            abort(403);
        $offer = Offer::findOrFail($id);
        return view('admin.offers.pending.additional-services.index', compact('offer'));
    }

    public function storeAdditionalServices(Request $request, Offer $offer)
    {
        if (!Auth::user('admin')->can('create offers.additionalServices'))
            abort(403);
        if ($offer->status != OfferStatus::PENDING->value) {
            abort(404);
        }

        $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.title' => ['required', 'string'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.duration' => ['required', 'integer', 'min:1'],
            'items.*.amount' => ['required', 'numeric', 'min:0'],
            'items.*.start_date' => ['required', 'date'],
            'items.*.end_date' => ['required', 'date'],
            'items.*.specifications' => ['nullable', 'string'],
        ]);

        $data['items'] = $request->items;
        $data['offer_id'] = $offer->id;

        $result = $this->offerService->createAdditionalServices($data);
        return redirect()->route('admin.offers.pending.edit', $offer->id)->with('success', 'created successfully');
    }
}
